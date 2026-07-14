const { PrismaClient } = require('@prisma/client');
const { PrismaPg } = require('@prisma/adapter-pg');
const pg = require('pg');

const pool = new pg.Pool({ connectionString: process.env.DATABASE_URL });
const adapter = new PrismaPg(pool);
const prisma = new PrismaClient({ adapter });

async function main() {
  console.log('🌱 Mulai menanam data dummy ICAREMU...');

  // 1. Bikin Akun Guru UKS
  const guruUks = await prisma.user.create({
    data: {
      email: 'guru.uks@smkmuh1.sch.id',
      password: 'password', // Nanti kita enkripsi pakai bcrypt
      role: 'guru_uks',
    },
  });

  // 2. Bikin Data Siswa Dummy
  const siswa1 = await prisma.siswa.create({
    data: {
      nisn: '0011223344',
      nama_lengkap: 'Arya Sang Kapten',
      jenis_kelamin: 'L',
      golongan_darah: 'O',
      nama_ortu: 'Bapak Arya',
      no_wa_ortu: '081234567890',
    },
  });

  // 3. Bikin Rekam Medis Awal (Pancingan buat Dashboard)
  await prisma.rekamMedis.create({
    data: {
      siswa_id: siswa1.id,
      tinggi_badan: 165.5,
      berat_badan: 55.0,
      imt_score: 20.1, // Contoh normal
      status_kesehatan: 'Normal',
    },
  });

  console.log('✅ Penanaman data sukses, Kapten!');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });