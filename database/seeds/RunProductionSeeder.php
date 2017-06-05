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
            Waypoint::create(["name" => $n]);
        });

        // seeds creation ========================
        collect([
            ["day" => new DateTime('2017-07-18'), "nbRuns" => 15],
            ["day" => new DateTime('2017-07-19'), "nbRuns" => 25],
            ["day" => new DateTime('2017-07-20'), "nbRuns" => 35],
            ["day" => new DateTime('2017-07-21'), "nbRuns" => 45],
            ["day" => new DateTime('2017-07-22'), "nbRuns" => 35],
            ["day" => new DateTime('2017-07-23'), "nbRuns" => 25],
            ["day" => new DateTime('2017-07-24'), "nbRuns" => 15]
        ])->each(function ($onedate)
        {
            for ($r = 0; $r < $onedate["nbRuns"]; $r++)
            {
                $onedate["day"]->setTime(rand(1, 23), rand(0, 11) * 5);
                $artist = $this->artists[rand(0, count($this->artists) - 1)];
                $note = (rand(1,100) > 80 ? $this->notes[rand(0, count($this->notes) - 1)] : null);
                $nbPax = rand(1, 9);
                $textItinerary = array();
                $intItinerary = array();
                $nbwp = (rand(1,100) > 80) ? (rand(1,100) > 80) ? 4 : 3 : 2;
                for ($wp = 0; $wp < $nbwp; $wp++)
                {
                    $wpidx = rand(0, count($this->wayPoints) - 1);
                    $textItinerary[] = $this->wayPoints[$wpidx];
                    $intItinerary[] = $wpidx;
                }
                echo $onedate["day"]->format('Y-m-d H:i:s').", $artist, $nbPax pax, ".implode('->',$textItinerary).(isset($note) ? ", note:$note": "")."\n";
                /*/
                $run = Run::create([
                    'started_at' => $onedate["day"]->format('Y-m-d H:i:s'),
                    'ended_at' => null,
                    'planned_at' => $onedate["day"]->format('Y-m-d H:i:s'),
                    'nb_passenger' => $nbPax,
                    'name' => $artist,
                    'note' => $this->notes->first(),
                    'created_at' => date('Y-m-d h:m:s'),
                    'updated_at' => date('Y-m-d h:m:s'),
                    'deleted_at' => null,
                ]);
                for ($i=0; $i < count($intItinerary); $i++) $run->waypoints()->attach($intItinerary[$i]);
                //*/
            }
        });
    }
}
