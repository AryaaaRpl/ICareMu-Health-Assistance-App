# Enterprise Backend Architecture Documentation - ICAREMU

**Project Name**: ICAREMU Healthcare School System (Multi-Tenant SaaS Backend)  
**Stack**: Laravel 12, PHP 8.4, MySQL 8.0, Redis, Sanctum, Spatie Permission, Spatie Activity Log  
**Standards**: Clean Architecture, Repository Pattern, Service Layer, DTO Pattern, Action Pattern, SOLID, PSR-12  

---

## 1. Folder Structure

```
ICAREMU-Health-Assistance-App-laravel/
├── app/
│   ├── Actions/                  # Atomic single-responsibility business operations
│   │   ├── Auth/                 # LoginAction, RegisterAction, RefreshTokenAction
│   │   ├── Inventory/            # DeductStockAction, FlagExpiredItemsAction
│   │   └── Medical/              # CalculateImtAction, VerifyMedicalRecordAction
│   ├── Core/
│   │   └── Tenant/               # TenantContext, TenantResolver, MultiTenantContract
│   ├── Console/
│   │   └── Commands/             # FlagExpiredMedicinesCommand, SendScreeningRemindersCommand
│   ├── DTOs/                     # PHP 8.4 Readonly Data Transfer Objects
│   │   ├── Auth/                 # LoginDTO, RegisterDTO
│   │   ├── Inventory/            # CreateInventoryDTO, StockUpdateDTO
│   │   ├── Medical/              # CreateMedicalRecordDTO
│   │   └── Siswa/                # CreateSiswaDTO, UpdateSiswaDTO
│   ├── Events/                   # Domain events (MedicalRecordCreated, StockDepleted)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── V1/           # REST API Version 1 Controllers
│   │   ├── Middleware/           # TenantResolverMiddleware, ForceJsonResponseMiddleware
│   │   └── Requests/             # Form Requests with custom business validation
│   ├── Listeners/                # Event Listeners (AuditLogListener, SendNotificationListener)
│   ├── Models/                   # Eloquent models implementing TenantAware interface
│   │   └── Scopes/               # TenantScope (Global Eloquent Scope for tenant isolation)
│   ├── Observers/                # RekamMedisObserver, InventarisUksObserver
│   ├── Policies/                 # Laravel Policies connected to Spatie RBAC
│   ├── Providers/                # AppServiceProvider, RepositoryServiceProvider
│   ├── Repositories/             # Repository Pattern
│   │   ├── Contracts/            # Interfaces for data access contracts
│   │   └── Eloquent/             # Concrete Eloquent implementations
│   └── Services/                 # Business logic orchestrators
├── config/                       # Sanctum, Permission, Audit, Database configs
├── database/
│   ├── migrations/               # Database ERD Schema definitions
│   └── seeders/                  # Role, Permission, Super Admin & Demo Tenant Seeders
├── docs/
│   └── ARCHITECTURE.md           # Master System Architecture Document
├── routes/
│   └── api.php                   # Versioned REST API routes (/api/v1/...)
└── tests/
    ├── Feature/                  # API, Authentication & Multi-Tenancy integration tests
    └── Unit/                     # DTO, Actions & Repository unit tests
```

---

## 2. Architecture Diagram

```
[ Client Request ] (SPA / Mobile App)
       │
       ▼
[ HTTP Request / API Endpoint ] (/api/v1/...)
       │
       ▼
[ ForceJsonResponseMiddleware ] ──▶ [ TenantResolverMiddleware ]
                                              │
                                              ▼ (Sets TenantContext)
                                    [ Sanctum Auth Middleware ]
                                              │
                                              ▼
                                   [ Form Request Validation ]
                                              │
                                              ▼ (Passes Validated DTO)
                                    [ API Controller ]
                                              │
                                              ▼
                                     [ Policy Check (RBAC) ]
                                              │
                                              ▼
                                    [ Action / Service Layer ]
                                              │
                    ┌─────────────────────────┴─────────────────────────┐
                    ▼                                                   ▼
         [ Eloquent Repository ]                             [ Domain Event Trigger ]
                    │                                                   │
                    ▼ (Applies TenantScope automatically)                ▼
               [ MySQL DB ]                                   [ Queue Worker / Redis ]
                                                                        │
                                                                        ▼
                                                             [ Listener / Notification ]
```

---

## 3. ERD Explanation & Relationships

- **sekolahs**: Root Tenant entity. All school data stems from this core entity.
- **users**: System users with role assignments (Super Admin, School Admin, Doctor, UKS Officer, Teacher, Student). Linked optionally to `sekolah_id` (Super Admin `sekolah_id` is null).
- **siswas**: Student profiles linked to `user_id` and `sekolah_id`.
- **rekam_medis**: Medical examination records linked to `siswa_id`, `sekolah_id`, and `created_by` (Doctor/Officer). Contains IMT scores and risk status. Immutable once verified.
- **kesehatan_reproduksis**: Female health tracking records linked to `siswa_id` and `sekolah_id`.
- **jadwal_skrining**: Health screening event schedules linked to `sekolah_id`.
- **peserta_skrining**: Screening participation records linking `jadwal_id` and `siswa_id`.
- **inventaris_uks**: UKS medicine & equipment inventory with stock and expiry dates.
- **riwayat_konsultasi**: Medical consultation Q&A logs between students and medical professionals.

---

## 4. Authentication Flow

1. **Client POST /api/v1/auth/login**: Sends credentials (`email`, `password`).
2. **LoginAction Execution**: Validates credentials using `Auth::attempt()`.
3. **Tenant & Token Generation**: Reads user's role and associated `sekolah_id`. Issues Sanctum Personal Access Token with specific token abilities.
4. **Response**: Returns bearer token, user payload, roles, permissions, and tenant context.
5. **Authenticated Requests**: Client sends `Authorization: Bearer <token>` in header. Sanctum authenticates the user and attaches user model to request context.
6. **Token Refresh & Revocation**: POST `/api/v1/auth/refresh` revokes current token and issues new token; POST `/api/v1/auth/logout` revokes current token.

---

## 5. Authorization Flow (Spatie RBAC & Policies)

- **Role Taxonomy**:
  - `Super Admin`: System-wide access across all tenant schools.
  - `School Admin`: Full management of their specific school tenant.
  - `Doctor`: Verification of health records, conducting consultations, screening.
  - `UKS Officer`: Managing UKS inventory, logging screening, recording medical logs.
  - `Teacher`: Read-only student health summaries for their school.
  - `Student`: Read-only access exclusively to their personal health records and creating consultation requests.
- **Enforcement**:
  - Controller actions invoke `$this->authorize('view', $model)` or `Gate::authorize()`.
  - Policies check both Spatie permissions (e.g. `medical.create`) and tenant ownership (`$user->sekolah_id === $model->sekolah_id`).

---

## 6. Tenant Flow (Multi-Tenant Isolation)

- **Tenant Context (`TenantContext`)**: Thread-safe singleton storing the currently resolved school ID.
- **Tenant Resolver Middleware**:
  - Reads authenticated user's `sekolah_id`.
  - Fallback checks `X-Tenant-ID` header if authorized (Super Admin header override).
  - Initializes `TenantContext::setTenantId($sekolahId)`.
- **TenantScope (Global Eloquent Scope)**:
  - Automatically appends `WHERE sekolah_id = ?` to all model queries.
  - Automatically assigns `sekolah_id` upon model creation (`creating` lifecycle event).
  - Bypassed cleanly when `TenantContext::isSuperAdmin()` returns `true`.

---

## 7. API Documentation (Standard Envelope & Endpoints)

### Envelope Standard
**Success Response (HTTP 200/201)**:
```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": {},
  "meta": {
    "timestamp": "2026-07-22T21:53:47+07:00",
    "version": "v1"
  }
}
```

**Error Response (HTTP 400/401/403/404/422/500)**:
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### Core API Endpoints
- `POST /api/v1/auth/register` - Register user/school
- `POST /api/v1/auth/login` - Authenticate user
- `POST /api/v1/auth/logout` - Revoke current token
- `GET /api/v1/auth/me` - Get current authenticated user details
- `GET|POST /api/v1/sekolahs` - School management (Super Admin)
- `GET|POST|PUT|DELETE /api/v1/siswas` - Student management
- `GET|POST|PUT /api/v1/rekam-medis` - Medical records management
- `POST /api/v1/rekam-medis/{id}/verify` - Doctor verification action
- `GET|POST|PUT|DELETE /api/v1/inventaris` - UKS inventory management
- `GET|POST /api/v1/jadwal-skrining` - Screening schedules
- `GET|POST /api/v1/konsultasi` - Consultation Q&A records
- `GET /api/v1/reports/health-summary` - Aggregate health report
- `POST /api/v1/imports/siswas` - Bulk student import (Excel/CSV)
- `GET /api/v1/exports/medical-records` - Export medical records

---

## 8. Business Flow

1. **Student Registration**: School Admin imports or creates Student profiles (`siswas`).
2. **Health Examination**: UKS Officer / Doctor conducts health checks and creates `RekamMedis`. System automatically computes IMT and assigns `status_risiko` (Normal, Stunting, Obesity, Underweight).
3. **Medical Record Verification**: Doctor reviews the record and issues verification. Once verified, record becomes immutable.
4. **Screening Program**: School Admin schedules `JadwalSkrining`. Students are assigned to `PesertaSkrining`. Upon completion, results are logged into medical history.
5. **Inventory Monitoring**: UKS Officer dispenses medication. System deducts stock atomically. Scheduler flags items near expiry date (`tanggal_kedaluwarsa`).

---

## 9. Use Case Diagrams (Textual Matrix)

| Actor | Primary Use Cases |
| :--- | :--- |
| **Super Admin** | Manage Schools, System Audits, Full Cross-Tenant Access |
| **School Admin** | Manage School Users, Students, Schedules, View School Analytics |
| **Doctor** | Verify Medical Exams, Respond to Consultations, Conduct Screenings |
| **UKS Officer** | Record Physical Exams, Manage UKS Inventory, Track Expiries |
| **Teacher** | View Class Student Health Risk Summaries |
| **Student** | View Own Health Logs, Submit Consultation Questions, Check Screening Schedule |

---

## 10. Sequence Diagram (Medical Record Creation & Verification)

```
[ UKS Officer / Doctor ] ──▶ (POST /api/v1/rekam-medis) ──▶ [ Controller ]
                                                                 │
                                                                 ▼
                                                        [ CreateMedicalRecordDTO ]
                                                                 │
                                                                 ▼
                                                       [ MedicalRecordService ]
                                                                 │
                                                                 ▼
                                                      [ CalculateImtAction ]
                                                                 │ (Computes IMT & Risk)
                                                                 ▼
                                                     [ RekamMedisRepository ]
                                                                 │ (Applies TenantScope)
                                                                 ▼
                                                          [ MySQL Saved ]
                                                                 │
                                                                 ▼
                                                     [ Event: ExamRecorded ]
                                                                 │
                                                                 ▼
                                                      [ Queue: Send Notification ]
```

---

## 11. Deployment Guide

1. **Environment Setup**: Ensure PHP 8.4, MySQL 8.0, Redis 7.0, Nginx are installed.
2. **Dependencies**: Execute `composer install --no-dev --optimize-autoloader`.
3. **Environment Config**: Copy `.env.example` to `.env`. Set DB credentials, Redis host, `APP_ENV=production`, `APP_DEBUG=false`.
4. **Migrations & Seeders**: Run `php artisan migrate --force` and `php artisan db:seed --force`.
5. **Key Generation**: Run `php artisan key:generate`.
6. **Queue Worker**: Configure Supervisor for `php artisan queue:work redis --tries=3`.
7. **Scheduler Cron**: Add cron entry: `* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1`.

---

## 12. Queue System

- **Driver**: Redis (`QUEUE_CONNECTION=redis`).
- **Queued Jobs**:
  - `ProcessStudentImportJob`: Async handling of bulk Excel imports.
  - `SendExpiredMedicineNotificationJob`: Asynchronous mail dispatch.
  - `CalculateHealthAnalyticsJob`: Heavy statistical aggregation.
- **Failed Jobs**: Configured with `failed_jobs` database logging and retry policies.

---

## 13. Scheduler Tasks

- **`CheckExpiredMedicineCommand`**: Runs daily at 00:00 (`0 0 * * *`). Scans `inventaris_uks` for medicines expiring within 30 days and notifies UKS Officers.
- **`SendScreeningReminderCommand`**: Runs daily at 07:00 (`0 7 * * *`). Dispatches notifications to students scheduled for screenings on the current date.

---

## 14. Events & Listeners

- `MedicalRecordCreated` ──▶ `SendHighRiskAlertListener` (Triggers notification if IMT risk is severe).
- `StockDepleted` ──▶ `NotifyLowStockListener` (Alerts UKS Officer when item quantity reaches threshold).
- `ScreeningScheduled` ──▶ `GenerateParticipantsListener` (Populates screening participants automatically).

---

## 15. Model Observers

- **`RekamMedisObserver`**:
  - `creating`: Auto-calculates `imt_score` and `status_risiko` before DB insert; auto-populates `sekolah_id` from `TenantContext`.
  - `updating` / `deleting`: Throws exception if record `status_verifikasi` is marked as verified (Immutability guarantee).
- **`InventarisUksObserver`**:
  - `saving`: Validates that stock count never drops below zero (`stok >= 0`).

---

## 16. Policy Architecture

- All Policies inherit from base authorization logic:
  - `SiswaPolicy`: Guards read/write access to student records.
  - `RekamMedisPolicy`: Checks if user is Doctor/UKS Officer belonging to the same `sekolah_id`.
  - `InventarisPolicy`: Restricts inventory mutations to `UKS Officer` and `School Admin`.

---

## 17. Middleware Pipeline

1. **`ForceJsonResponseMiddleware`**: Forces `Accept: application/json` header for API consistency.
2. **`TenantResolverMiddleware`**: Resolves current tenant context from user token or request headers.
3. **`Sanctum` Authentication**: Validates Bearer token authenticity.
4. **`ThrottleRequestsMiddleware`**: Rate limits API requests (60 requests per minute per IP/user).

---

## 18. Repository Layer Architecture

- **`BaseRepositoryInterface`**: Defines standard CRUD contracts (`all`, `findById`, `create`, `update`, `delete`).
- **`SiswaRepositoryInterface` & `SiswaRepository`**: Specialized queries like `findByNisn`, `getStudentsBySchool`.
- **`RekamMedisRepositoryInterface` & `RekamMedisRepository`**: Retrieves patient history, filterable by date range and risk category.

---

## 19. Service Layer Architecture

- **`AuthService`**: Manages user registration, credential validation, Sanctum token generation, password resets.
- **`MedicalRecordService`**: Coordinates medical exam recording, IMT calculation, verification workflows.
- **`InventoryService`**: Handles stock additions, deductions, expiry audits within database transactions.
- **`ScreeningService`**: Manages screening event creation, participant roster population, and status updates.

---

## 20. Coding Standards (PSR-12 & Laravel Pint)

- Enforced via **Laravel Pint** and **PHPStan (Level 8)**.
- Strict Type Hints on all methods (`declare(strict_types=1);`).
- Explicit return types on all functions.
- Short closures (`fn() => ...`) where appropriate.

---

## 21. Naming Conventions

- **Models**: Singular PascalCase (`Siswa`, `RekamMedis`, `InventarisUks`).
- **Tables**: Plural snake_case (`siswas`, `rekam_medis`, `inventaris_uks`).
- **Controllers**: Singular PascalCase with Controller suffix (`SiswaController`).
- **Services & Repositories**: PascalCase with Service / Repository suffix (`MedicalRecordService`, `SiswaRepository`).
- **DTOs**: PascalCase with DTO suffix (`CreateMedicalRecordDTO`).
- **Actions**: PascalCase verb-first (`VerifyMedicalRecordAction`).

---

## 22. Future Scaling Strategy

1. **Database Sharding & Tenant Database Separation**: Migration path from single-database multi-tenancy (`sekolah_id` column) to dedicated tenant databases using spatie/laravel-multitenancy if tenant count exceeds 10,000 schools.
2. **Read/Write DB Splitting**: Configure separate MySQL replica read nodes in Laravel `config/database.php`.
3. **Redis Caching Layer**: Cache frequent lookup data (school metadata, user roles, inventory lists) with tenant-keyed Redis tags (`tenant:{sekolah_id}:inventory`).
4. **Event-Driven Microservices**: Offload heavy PDF/Excel generation and notification dispatching to dedicated serverless workers via AWS SQS / Redis Streams.
