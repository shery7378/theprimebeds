<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (EmailTemplate::where('type', 'New Order Admin')->count() == 0) {
            $emailTemplete = new EmailTemplate();
            $emailTemplete->type = 'New Order Admin';
            $emailTemplete->subject = 'New Order';
            $emailTemplete->body = '<p>You Got a order, Transaction number {transaction_number}</p>';
            $emailTemplete->save();
        }

        $this->call([
            AlexanderBedSeeder::class,
            AlexanderKidsBedSeeder::class,
            AllureBedSeeder::class,
            Ambassador2000PillowtopMattressSeeder::class,
            AmbassadorDivanBedSeeder::class,
            AmbassadorOttomanBedSeeder::class,
            AriXBedSeeder::class,
            ArielBedSeeder::class,
            AvaGraceBedSeeder::class,
            AvaGraceDivanBedSeeder::class,
            AvaGraceOttomanBedSeeder::class,
            AvabelleKidsBedSeeder::class,
            Bamboo5000MattressSeeder::class,
            BellaGraceKidsBedSeeder::class,
            BellagioDivanBedSeeder::class,
            BellagioOttomanBedSeeder::class,
            BellagioXBedSeeder::class,
            BellagioXLowBedSeeder::class,
            CariadBedSeeder::class,
            Celebration2000MattressSeeder::class,
            CelineBedSeeder::class,
            CharlieBedSeeder::class,
            Cloud3000MattressSeeder::class,
            CrosbyBedSeeder::class,
            DolsieBedSeeder::class,
            DelilahBedSeeder::class,
            EchoXBedSeeder::class,
            EllieDivanBedSeeder::class,
            EmersonKidsBedSeeder::class,
            FlorenceKidsBedSeeder::class,
            FranklinBedSeeder::class,
            FranklinDivanBedSeeder::class,
            FranklinOttomanBedSeeder::class,
            HugoBedSeeder::class,
            HugoDivanBedSeeder::class,
            HugoOttomanBedSeeder::class,
            Imperial1000PillowtopMattressSeeder::class,
            IndulgenceOttomanBedSeeder::class,
            InvictaLuxeKidsBedSeeder::class,
            IssyBedSeeder::class,
            IssyKidsBedSeeder::class,
            IvyOttomanBedSeeder::class,
            KikiBedSeeder::class,
            LilyBedSeeder::class,
            LottieBedSeeder::class,
            LylaSuperiorBedSeeder::class,
            MarinaKidsBedSeeder::class,
            MerryDivanBedSeeder::class,
            MerryKidsBedSeeder::class,
            MerryOttomanBedSeeder::class,
            MillhouseKidsBedSeeder::class,
            MountValeDivanBedSeeder::class,
            MountValeOttomanBedSeeder::class,
            OpulenceBedSeeder::class,
            Oxford2000MattressSeeder::class,
            RaeKidsBedSeeder::class,
            RichardsonRoyaleBedSeeder::class,
            RichardsonRoyaleDivanBedSeeder::class,
            RichardsonRoyaleOttomanBedSeeder::class,
            RobynBedSeeder::class,
            RoselynKidsBedSeeder::class,
            RosieBedSeeder::class,
            RosieDivanBedSeeder::class,
            RosieOttomanBedSeeder::class,
            SaharaBedSeeder::class,
            SensatoriBedSeeder::class,
            SensatoriDeluxeBedSeeder::class,
            SensatoriDivanBedSeeder::class,
            SensatoriHybridBedSeeder::class,
            SensatoriHybridDivanBedSeeder::class,
            SensatoriHybridOttomanBedSeeder::class,
            SensatoriKidsBedSeeder::class,
            SensatoriOttomanBedSeeder::class,
            SensatoriSignatureBedSeeder::class,
            SensatoriXBedSeeder::class,
            ShakespeareAllFoamMattressSeeder::class,
            SiennaKidsBedSeeder::class,
            SonoSignatureBedSeeder::class,
            SorelleKidsBedSeeder::class,
            SuperiorBedSeeder::class,
            TaraLuxeDivanBedSeeder::class,
            ValenciaBedSeeder::class,
            ZenBedSeeder::class,
            ZenDivanBedSeeder::class,
            ZenOttomanBedSeeder::class,
        ]);
    }
}