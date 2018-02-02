<?php

use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Illuminate\Database\Seeder;
use Lib\Models\Waypoint;
use Lib\Models\Run;

class RunProductionSeeder extends Seeder
{
    private $notes;
    private $artists;
    private $wayPoints;
    private $cars;
    private $drivers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->notes = collect([
            'Band départ 11 Pax',
            'Crew départ 1 Pax, 1 VALISE + 1 SAC',
            'invité arrivé 1 Pax',
            'crew départ 1 Pax, 1 grosse valise',
            'agent Départ 1 Pax',
            'band transfert 1 Pax',
            '1 cello / 1 KB flight case / 8 travel',
            'luggages',
            'divers transfert Pax'
        ]);

        $this->artists = [
            "RED HOT CHILI PEPPERS",
            "FOALS",
            "KALEO",
            "THE INSPECTOR CLUZO",
            "SATE",
            "TAXIWARS",
            "BARBAGALLO",
            "ALICE ROOSEVELT",
            "FOREIGN DIPLOMATS",
            "THE STACHES",
            "PETIT BISCUIT",
            "CARPENTER BRUT",
            "ISOLATED LINES",
            "LA-33",
            "CERO39",
            "BOOGÁT",
            "ARCADE FIRE",
            "PIXIES",
            "MIDNIGHT OIL",
            "TEMPLES",
            "HER",
            "ORCHESTRE TOUT PUISSANT MARCEL DUCHAMP XXL",
            "HYPERCULTE",
            "LEN SANDER",
            "JULIEN DORÉ",
            "FISHBACH",
            "RADIO ELVIS",
            "RONE",
            "MARABOUT",
            "CELSO PIÑA",
            "SYSTEMA SOLAR",
            "THE GARIFUNA COLLECTIVE",
            "JAMIROQUAI",
            "JUSTICE",
            "JUPITER & OKWESS",
            "NOVA TWINS",
            "POGO CAR CRASH CONTROL",
            "TRYO",
            "VIANNEY",
            "CYRIL MOKAIESH",
            "LOLA MARSH",
            "JÉRÉMIE KISLING",
            "MHD",
            "VALD",
            "ALACLAIR ENSEMBLE",
            "INNA DE YARD",
            "JAH9 & THE DUB TREATMENT",
            "PANTEÓN ROCOCÓ",
            "MACKLEMORE",
            "RYAN LEWIS",
            "BLACK M",
            "GEORGIO ALLTTA",
            "CAMILLE",
            "OCTAVE NOIRE",
            "NICOLAS MICHAUX",
            "ROCKY",
            "MARK KELLY",
            "JALEN N'GONDA",
            "FAI BABA",
            "LOS ORIOLES",
            "AURELIO",
            "KUMBIA BORUKA",
            "ÌFÉ",
            "CHRISTOPHE MAÉ",
            "RENAUD",
            "I MUVRINI",
            "RÉGIS",
            "GAUVAIN SERS",
            "BROKEN BACK",
            "MAT BASTARD",
            "SHAME",
            "ALAN CORBEL",
            "VITALIC ODC LIVE",
            "CLÉMENT BAZIN",
            "MEUTE",
            "BAUCHAMP",
            "ORKESTA MENDOZA",
            "EL FREAKY",
            "KUMBIA BORUKA",
            "MANU CHAO",
            "IMANY",
            "BACHAR MAR-KHALIFÉ",
            "PROFESSOR WOUASSA",
            "KENY ARKANA",
            "KILLASON",
            "KT GORIQUE",
            "FRENCH FUSE",
            "MEUTE",
            "MICHAËL GREGORIO",
            "BOULEVARD DES AIRS",
            "SANDOR",
            "ORCHESTRE DE CHAMBRE DE GENÈVE",
            "CALYPSO ROSE",
            "DELGRÈS",
            "SON DEL SALÓN"];

        $this->wayPoints = collect([
            "Grande scène",
            "Les Arches",
            "Le Dôme",
            "Prod",
            "Honda",
            "Détour",
            "Genève aéroport",
            "Chavannes",
            "Nyon Gare",
            "Lake Geneva Hotel",
            "Cressy",
            "Hilton Genève",
            "Formule 1 Versoix",
            "Best Western Mies",
            "Holiday Inn Coppet"
        ]);

        $this->wayPoints->each(function ($n)
        {
            Waypoint::create(["name" => $n, "geo"=>null]);
        });

        $this->cars = Car::all();
        $this->drivers = User::all();
        echo count($this->cars) . " véhicules\n";
        echo count($this->drivers) . " chauffeurs\n";

        // seeds creation ========================
        $dateOffset = env("TEST_DATA_DATE_OFFSET",0); // Number of days until start of festival
        $startDate = new DateTime(); // now
        if ($dateOffset >= 0)
            $startDate->add(new DateInterval("P".$dateOffset."D"));
        else
            $startDate->sub(new DateInterval("P".(-$dateOffset)."D"));
        echo "Runs start " . $startDate->format("Y-m-d") . "\n";

        collect([
            ["day" => $startDate, "nbRuns" => random_int(10, 30)],
            ["day" => (clone $startDate)->add(new DateInterval('P1D')), "nbRuns" => random_int(20, 50)],
            ["day" => (clone $startDate)->add(new DateInterval('P2D')), "nbRuns" => random_int(30, 70)],
            ["day" => (clone $startDate)->add(new DateInterval('P3D')), "nbRuns" => random_int(30, 50)],
            ["day" => (clone $startDate)->add(new DateInterval('P4D')), "nbRuns" => random_int(30, 50)],
            ["day" => (clone $startDate)->add(new DateInterval('P5D')), "nbRuns" => random_int(25, 40)],
            ["day" => (clone $startDate)->add(new DateInterval('P6D')), "nbRuns" => random_int(10, 20)]
        ])->each(function ($onedate)
        {
            echo "Runs for " . $onedate["day"]->format("Y-m-d") . "\n";
            for ($r = 0; $r < $onedate["nbRuns"]; $r++)
            {
                $simulatedCurrentDateTime = new DateTime();
                $simulatedCurrentDateTime->setDate(2017, 7, 20);
                $simulatedCurrentDateTime->setTime(14, 15, 0);

                $onedate["day"]->setTime(rand(1, 23), rand(0, 11) * 5); // Pick a random time within the day
                $plannedAt = $onedate["day"];

                // Run status depends on $simulatedCurrentDateTime and $plannedAt:
                // if the run planned start is in the past -> the run has started
                // if the run start is more than 2 hours in the past -> the run has ended
                // if the run start is more than 30 minutes in the future -> the run has not started
                // inbetween, the run is in progress
                // All runs ended or in progress have fully defined convoys
                // runs in the future may have incomplete convoys
                $diff = $simulatedCurrentDateTime->diff($plannedAt);
                $minDiff = 24 * 60 * $diff->d + 60 * $diff->h + $diff->i;
                if ($plannedAt < $simulatedCurrentDateTime)
                {
                    $startedAt = $plannedAt->format('Y-m-d H:i:s'); // run started as planned
                    if ($minDiff > 120) // it has ended
                        $endedAt = $plannedAt->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
                    else
                        $endedAt = null;

                } else
                {
                    $startedAt = null;
                    $endedAt = null;
                }

                $artist = $this->artists[rand(0, count($this->artists) - 1)];
                $note = (rand(1, 100) > 80 ? $this->notes->random() : null);
                $nbPax = rand(1, 9);
                $run = Run::create([
                    'started_at' => $startedAt,
                    'ended_at' => $endedAt,
                    'planned_at' => $plannedAt->format('Y-m-d H:i:s'),
                    'nb_passenger' => $nbPax,
                    'name' => $artist,
                    'note' => $note,
                    'created_at' => date('Y-m-d h:m:s'),
                    'updated_at' => date('Y-m-d h:m:s'),
                    'deleted_at' => null,
                ]);
                $run->publish();
                $nbwp = (rand(1, 100) > 80) ? (rand(1, 100) > 80) ? 4 : 3 : 2;
                for ($wp = 0; $wp < $nbwp; $wp++) $run->waypoints()->attach(rand(1, count($this->wayPoints)));

                // Now convoys
                if ($startedAt == null) // run in the future
                {
                    if ($minDiff < 15) // start in 15 minutes or less -> fully defined (ready)
                    {
                        $nbconvoys = (rand(1, 100) > 80) ? (rand(1, 100) > 80) ? 3 : 2 : 1;
                        for ($i = 0; $i < $nbconvoys; $i++)
                        {
                            $car = $this->cars->random();
                            $driver = $this->drivers->random();
                            $sub = new Lib\Models\RunSubscription();
                            $sub->run()->associate($run);
                            $sub->user()->associate($driver);
                            $sub->car()->associate($car);
                            $sub->car_type()->associate($car->car_type_id);
                            $sub->save();
                        }
                    } else
                        if ($minDiff < 120) // start in 15 to 120 minutes -> cartype is defined but either car or driver or both or none is not defined
                        {
                            $sub = new Lib\Models\RunSubscription();
                            $car = $this->cars->random();
                            $sub->car_type()->associate($car->car_type_id);
                            if (rand(1, 100) > 50)
                            {
                                $driver = $this->drivers->random();
                                $sub->user()->associate($driver);
                            }
                            if (rand(1, 100) > 50)
                            {
                                $sub->car()->associate($car);
                            }
                            $sub->run()->associate($run);
                            $sub->save();
                        } else // more than 2 hours in the future -> some have a cartype defined
                        {
                            if (rand(1, 100) > 80)
                            {
                                $sub = new Lib\Models\RunSubscription();
                                $car = $this->cars->random();
                                $sub->car_type()->associate($car->car_type_id);
                                $sub->run()->associate($run);
                                $sub->save();
                            }
                        }
                } else // run started: convoys must be defined
                {
                    $nbconvoys = (rand(1, 100) > 80) ? (rand(1, 100) > 80) ? 3 : 2 : 1;
                    for ($i = 0; $i < $nbconvoys; $i++)
                    {
                        $car = $this->cars->random();
                        $driver = $this->drivers->random();
                        $sub = new Lib\Models\RunSubscription();
                        $sub->run()->associate($run);
                        $sub->user()->associate($driver);
                        $sub->car()->associate($car);
                        $sub->car_type()->associate($car->car_type_id);
                        $sub->save();
                    }
                }
            }
        });
    }
}
