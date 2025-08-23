<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(30)->create();

        User::factory()->create([
            'full_name' => 'Pero Perić',
            'email' => 'student@example.com',
            'pin' => "jmbag",
            'pin_value' => "1234567891",
            'gender' => "m",
            'status' => "r",
            "registration_type" => "student",
            'role' => "student",
            'is_allowed' => true,
            'is_in_pending_status' => false
        ]);

        User::factory()->create([
            'full_name' => 'Ana Anić',
            'email' => 'nastavnik@example.com',
            'pin' => "oib",
            'pin_value' => "00000000000",
            'gender' => "f",
            'status' => "n",
            "registration_type" => "teacher",
            'role' => "teacher",
            "password" => Hash::make("password"),
            'is_allowed' => false,
            'is_in_pending_status' => true
        ]);

        User::factory()->create([
            'full_name' => 'Luka Lukić',
            'email' => 'admin@example.com',
            'pin' => "oib",
            'pin_value' => "00000000001",
            'gender' => "m",
            'status' => "n",
            "registration_type" => "teacher",
            'role' => "admin",
            "password" => Hash::make("password"),
            'is_allowed' => true,
            'is_in_pending_status' => false
        ]);

        Exam::factory(1)->create();
        $exam = Exam::first();

        $questionsData = [
            [
                "question" => "Koja je osnovna razlika između HTTP i HTTPS protokola?",
                "answers" => [
                    "1" => "HTTPS koristi enkripciju podataka putem TLS/SSL",
                    "2" => "HTTPS radi na portu 21",
                    "3" => "HTTP i HTTPS su potpuno isti protokoli",
                    "is_correct" => "HTTPS koristi enkripciju podataka putem TLS/SSL"
                ],
            ],
            [
                "question" => "U SQL-u, što radi naredba WITH RECURSIVE?",
                "answers" => [
                    "1" => "Pokreće SQL upit unutar petlje",
                    "2" => "Omogućuje rekurzivne CTE-ove za hijerarhijske podatke",
                    "3" => "Briše podatke rekurzivno iz više tablica",
                    "is_correct" => "Omogućuje rekurzivne CTE-ove za hijerarhijske podatke"
                ],
            ],
            [
                "question" => "Koji je ispravan HTTP status kod za 'Unauthorized'?",
                "answers" => [
                    "1" => "401",
                    "2" => "403",
                    "3" => "404",
                    "is_correct" => "401"
                ],
            ],
            [
                "question" => "U JavaScriptu, koja je razlika između '==' i '===' operatora?",
                "answers" => [
                    "1" => "=== uspoređuje i vrijednost i tip podatka",
                    "2" => "Oba uspoređuju samo vrijednost",
                    "3" => "== uspoređuje samo tip podatka",
                    "is_correct" => "=== uspoređuje i vrijednost i tip podatka"
                ],
            ],
            [
                "question" => "Koja je svrha CSRF tokena u web aplikacijama?",
                "answers" => [
                    "1" => "Zaštita od Cross-Site Request Forgery napada",
                    "2" => "Za enkripciju lozinki",
                    "3" => "Za keširanje podataka",
                    "is_correct" => "Zaštita od Cross-Site Request Forgery napada"
                ],
            ],
            [
                "question" => "Koji SQL JOIN vraća sve zapise iz lijeve tablice i podudarne zapise iz desne tablice?",
                "answers" => [
                    "1" => "LEFT JOIN",
                    "2" => "INNER JOIN",
                    "3" => "FULL JOIN",
                    "is_correct" => "LEFT JOIN"
                ],
            ],
            [
                "question" => "Što znači pojam 'hoisting' u JavaScriptu?",
                "answers" => [
                    "1" => "Premještanje deklaracija varijabli i funkcija na vrh njihovog scopea",
                    "2" => "Automatska optimizacija koda",
                    "3" => "Automatsko brisanje neiskorištenih varijabli",
                    "is_correct" => "Premještanje deklaracija varijabli i funkcija na vrh njihovog scopea"
                ],
            ],
            [
                "question" => "Koji je ispravan način definiranja arrow funkcije u JavaScriptu?",
                "answers" => [
                    "1" => "const add = (a, b) => a + b;",
                    "2" => "function => add(a,b) { return a + b; }",
                    "is_correct" => "const add = (a, b) => a + b;"
                ],
            ],
            [
                "question" => "U HTML-u, koji je element semantički ispravan za navigacijske linkove?",
                "answers" => [
                    "1" => "<nav>",
                    "2" => "<section>",
                    "3" => "<article>",
                    "is_correct" => "<nav>"
                ],
            ],
            [
                "question" => "Koja je glavna svrha Docker-a u web developmentu?",
                "answers" => [
                    "1" => "Kreiranje izoliranih okruženja za aplikacije",
                    "2" => "Izrada grafičkog sučelja",
                    "3" => "Pisanje SQL upita",
                    "is_correct" => "Kreiranje izoliranih okruženja za aplikacije"
                ],
            ],
            [
                "question" => "Što znači pojam 'event bubbling' u JavaScriptu?",
                "answers" => [
                    "1" => "Prosljeđivanje događaja od ciljanog elementa prema roditeljskim elementima",
                    "2" => "Prekidanje izvršavanja događaja",
                    "3" => "Smanjenje veličine događaja",
                    "is_correct" => "Prosljeđivanje događaja od ciljanog elementa prema roditeljskim elementima"
                ],
            ],
            [
                "question" => "Koji je ispravan način deklariranja konstantne varijable u JavaScriptu?",
                "answers" => [
                    "1" => "const PI = 3.14;",
                    "2" => "var PI = 3.14;",
                    "is_correct" => "const PI = 3.14;"
                ],
            ],
            [
                "question" => "Koja je razlika između 'localStorage' i 'sessionStorage' u web preglednicima?",
                "answers" => [
                    "1" => "localStorage traje dok se ručno ne obriše, sessionStorage traje dok je tab otvoren",
                    "2" => "sessionStorage se koristi za keširanje API poziva",
                    "is_correct" => "localStorage traje dok se ručno ne obriše, sessionStorage traje dok je tab otvoren"
                ],
            ],
            [
                "question" => "Koji je ispravan redoslijed faza u HTTP request/response ciklusu?",
                "answers" => [
                    "1" => "Request → Processing → Response",
                    "2" => "Response → Request → Processing",
                    "is_correct" => "Request → Processing → Response"
                ],
            ],
            [
                "question" => "U PHP-u, koja funkcija vraća broj elemenata u nizu?",
                "answers" => [
                    "1" => "count()",
                    "2" => "sizeof()",
                    "3" => "length()",
                    "is_correct" => "count()"
                ],
            ],
            [
                "question" => "Koja od navedenih tehnologija omogućuje dvosmjernu komunikaciju u stvarnom vremenu?",
                "answers" => [
                    "1" => "WebSockets",
                    "2" => "AJAX",
                    "3" => "REST API",
                    "is_correct" => "WebSockets"
                ],
            ],
            [
                "question" => "Koja je ispravna sintaksa za SQL indeksiranje?",
                "answers" => [
                    "1" => "CREATE INDEX idx_name ON table(column);",
                    "2" => "INDEX CREATE idx_name ON table(column);",
                    "is_correct" => "CREATE INDEX idx_name ON table(column);"
                ],
            ],
            [
                "question" => "Koja metoda u JavaScriptu vraća novi niz s rezultatima funkcije pozvane za svaki element?",
                "answers" => [
                    "1" => "map()",
                    "2" => "forEach()",
                    "3" => "filter()",
                    "is_correct" => "map()"
                ],
            ],
            [
                "question" => "Koja je svrha middleware-a u web aplikacijama?",
                "answers" => [
                    "1" => "Presretanje i obrada zahtjeva prije nego što stignu do kontrolera",
                    "2" => "Izrada CSS stilova",
                    "is_correct" => "Presretanje i obrada zahtjeva prije nego što stignu do kontrolera"
                ],
            ],
            [
                "question" => "Koji je točan opis REST arhitekture?",
                "answers" => [
                    "1" => "Arhitektura temeljena na resursima koja koristi HTTP metode za manipulaciju podacima",
                    "2" => "Arhitektura za real-time dvosmjernu komunikaciju",
                    "is_correct" => "Arhitektura temeljena na resursima koja koristi HTTP metode za manipulaciju podacima"
                ],
            ],
        ];

        foreach ($questionsData as $qData) {
            Question::create([
                "question" => $qData['question'],
                "answers" => $qData['answers'],
                "exam_id" => $exam->id,
                "image" => null,
            ]);
        }
    }
}
