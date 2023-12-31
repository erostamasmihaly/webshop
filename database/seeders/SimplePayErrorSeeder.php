<?php

namespace Database\Seeders;

use App\Models\SimplePayError;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimplePayErrorSeeder extends Seeder
{

    public function run(): void
    {
        // OTP SimplePay tranzkaciós hibakódok összegyűjtése
        $array[0] = 'Sikeres művelet';
        $array[999] = 'Általános hibakód.';
        $array[1003] = 'Elutasított művelet';
        $array[1200] = 'Érvénytelen aláírás';
        $array[1400] = 'Kártya tárolási hiba';
        $array[1500] = 'Tárolt kártya nem található';
        $array[1529] = 'SimplePay belső hiba';
        $array[1600] = 'Invalid külső azonosító';
        $array[1650] = 'A tranzakció már létezik (és nincs újraindíthatóként jelölve).';
        $array[1800] = 'Tárolt kártya esetén invalid összeg';
        $array[1900] = 'Belső hiba';
        $array[2000] = 'Invalid devizanem';
        $array[2003] = 'Megadott jelszó érvénytelen';
        $array[2004] = 'Általános hibakód';
        $array[2006] = 'Megadott kereskedő nem található';
        $array[2008] = 'Megadott e-mail nem megfelelő';
        $array[2010] = 'Megadott tranzakcióazonosító nem megfelelő';
        $array[2013] = 'Nincs elég fedezet a kártyán';
        $array[2014] = 'Fizetéshez jelszó szükséges';
        $array[2016] = 'A felhasználó megszakította a fizetés';
        $array[2019] = 'Időtúllépés az elfogadói kommunikációban';
        $array[2020] = 'Elfogadó bank oldali hiba';
        $array[2021] = 'Kártyakibocsátó interaktív 3DS ellenőrzést igényel';
        $array[2030] = 'Kártya nem törölhető, mert egyenlege pozitív / Megadott összeg helytelen';
        $array[2040] = 'Érvénytelen devizanem';
        $array[2063] = 'Kártya inaktív';
        $array[2064] = 'Hibás bankkártya adatok';
        $array[2065] = 'Megadott kártya bevonása szükséges / nem létező kártya';
        $array[2066] = 'Kártya nem terhelhető / limittúllépés miatt';
        $array[2068] = 'Kártya adat hiba / nem létező kártya';
        $array[2070] = 'Nem megfelelő kártya típus';
        $array[2071] = 'Hibás bankkártya adatok / nem létező kártya';
        $array[2072] = 'Kártya lejárat nem megfelelő / nem létező kártya';
        $array[2073] = 'A megadott CVC nem megfelelő / nem létező kártya';
        $array[2074] = 'Kártyabirtokos neve több, mint 32 karakter';
        $array[2077] = 'Érvénytelen CVC';
        $array[2078] = 'Általános hiba, a kártyakibocsátó bank nem adja meg a hiba okát';
        $array[2079] = 'A routingnak megfelelő elfogadó bank nem érhető el';
        $array[2121] = 'Érvénytelen recurring amount';
        $array[2999] = 'SimplePay belső hiba';
        $array[3000] = 'Általános 3DS hiba';
        $array[3001] = 'Érvénytelen 3DS válaszüzenet';
        $array[3002] = '3DS folyamat hiba';
        $array[3003] = '3DS folyamat hiba';
        $array[3004] = 'Redirect 3DS challenge folyamán (vásárló átirányítása szükséges a kártyakibocsátó ACS szerverére a kapott URL felhasználásával)';
        $array[3005] = '3D secure interaktív azonosítás szükséges';
        $array[3006] = '3DS hiba, banki válasz nem érkezik meg, banki válasz késve érkezik meg';
        $array[3012] = '3DS folyamat hiba, nem 3DS képes kártya, 3DS valamelyik szereplőnél levő probléma';
        $array[3013] = '3DS folyamat hiba';
        $array[3101] = 'Érvénytelen 3DS válaszüzenet';
        $array[3102] = 'Érvénytelen 3DS verzió';
        $array[3103] = '3DS belső hiba';
        $array[3201] = '3DS adathiány';
        $array[3202] = '3DS adathiba';
        $array[3203] = '3DS adat formátum hiba, vagy szükséges adat hiánya';
        $array[3204] = '3DS belső hiba';
        $array[3301] = '3DS belső hiba';
        $array[3302] = '3DS belső hiba';
        $array[3303] = '3DS belső hiba';
        $array[3304] = '3DS belső hiba';
        $array[3305] = '3DS adathiba';
        $array[3306] = '3DS adathiba';
        $array[3307] = '3DS adathiba';
        $array[3402] = '3DS timeout';
        $array[3403] = '3DS rendszerhiba';
        $array[3404] = '3DS rendszerhiba';
        $array[3405] = '3DS rendszerhiba';
        $array[3500] = '3DS ACS általános hiba, kártyakibocsátó bank oldal';
        $array[3501] = '3DS ACS kártyakibocsátó bank oldal, a felhasználó megszakította az interaktív ellenőrzés (challenge) folyamatát';
        $array[3504] = '3DS ACS timeout, kártyakibocsátó bank oldal';
        $array[3505] = '3DS ACS timeout, kártyakibocsátó bank oldalról nem-, vagy nem időben érkezik válasz';
        $array[3506] = '3DS ACS tranzakció hiba, kártyakibocsátó bank oldali';
        $array[3507] = '3DS ACS ismeretlen hiba, kártyakibocsátó bank oldal';
        $array[3508] = '3DS ACS tranzakció hiba, kártyakibocsátó bank oldali komponensben';
        $array[3911] = '3DS adathiba';
        $array[3912] = '3DS adathiba';
        $array[5000] = 'Általános hibakód';
        $array[5010] = 'A kereskedői fiók nem található';
        $array[5011] = 'A tranzakció nem található';
        $array[5012] = 'A kereskedői fiók nem egyezik meg';
        $array[5013] = 'A tranzakció már létezik (és nincs újraindíthatóként jelölve).';
        $array[5014] = 'A tranzakció nem megfelelő típusú';
        $array[5015] = 'A tranzakció éppen fizetés alatt';
        $array[5016] = 'Tranzakció időtúllépés (elfogadói/acquirer oldal felől érkező kérés során).';
        $array[5017] = 'A tranzakció meg lett szakítva (elfogadói/acquirer oldal felől érkező kérés során).';
        $array[5018] = 'A tranzakció már kifizetésre került (így újabb művelet nem kezdeményezhető).';
        $array[5020] = 'A kérésben megadott érték vagy az eredeti tranzakcióösszeg ("originalTotal") ellenőrzése sikertelen';
        $array[5021] = 'A tranzakció már lezárásra került (így újabb Finish művelet nem kezdeményezhető).';
        $array[5022] = 'A tranzakció nem a kéréshez elvárt állapotban van.';
        $array[5023] = 'Ismeretlen / nem megfelelő fiók devizanem.';
        $array[5026] = 'Tranzakció letiltva (sikertelen fraud-vizsgálat következtében).';
        $array[5029] = 'A tranzakció jelenleg még nem refundolható (banki háttérműveletek)';
        $array[5030] = 'A művelet nem engedélyezett';
        $array[5040] = 'Tárolt kártya nem található';
        $array[5041] = 'Tárolt kártya lejárt';
        $array[5042] = 'Tárolt kártya inaktíválva';
        $array[5043] = 'Tárolt kártya előkészített, de még nem aktív';
        $array[5044] = 'Recurring nincs engedélyezve';
        $array[5048] = 'Recurring until szükséges';
        $array[5049] = 'Recurring until eltér';
        $array[5071] = 'Tárolt kártya érvénytelen hossz';
        $array[5072] = 'Tárolt kártya érvénytelen művelet';
        $array[5081] = 'Recurring token nem található';
        $array[5082] = 'Recurring token használatban';
        $array[5083] = 'Token times szükséges';
        $array[5084] = 'Token times túl nagy';
        $array[5085] = 'Token until szükséges';
        $array[5086] = 'Token until túl nagy';
        $array[5087] = 'Token maxAmount szükséges';
        $array[5088] = 'Token maxAmount túl nagy';
        $array[5089] = 'Recurring és oneclick regisztráció egyszerre nem indítható egy tranzakcióban';
        $array[5090] = 'Recurring token szükséges';
        $array[5091] = 'Recurring token inaktív';
        $array[5092] = 'Recurring token lejárt';
        $array[5093] = 'Recurring account eltérés';
        $array[5110] = 'Nem megfelelő visszatérítendő összeg.';
        $array[5111] = 'Az orderRef és a transactionId közül az egyik küldése kötelező';
        $array[5113] = 'A hívó kliensprogram megnevezése,verziószáma ("sdkVersion") kötelező.';
        $array[5201] = 'A kereskedői fiók azonosítója ("merchant") hiányzik.';
        $array[5213] = 'A kereskedői tranzakcióazonosító ("orderRef") hiányzik.';
        $array[5216] = 'Érvénytelen szállítási összeg';
        $array[5219] = 'Email cím ("customerEmail") hiányzik, vagy nem email fotmátumu.';
        $array[5220] = 'A tranzakció nyelve ("language") nem megfelelő';
        $array[5223] = 'A tranzakció pénzneme ("currency") nem megfelelő, vagy hiányzik.';
        $array[5302] = 'Nem megfelelő aláírás (signature) a beérkező kérésben. (A kereskedői API-ra érkező hívás aláírás-ellenőrzése sikertelen.)';
        $array[5303] = 'Nem megfelelő aláírás (signature) a beérkező kérésben. (A kereskedői API-ra érkező hívás aláírás-ellenőrzése sikertelen.)';
        $array[5304] = 'Időtúllépés miatt sikertelen hívás.';
        $array[5305] = 'Sikertelen tranzakcióküldés a fizetési rendszer (elfogadói/acquirer oldal) felé.';
        $array[5306] = 'Sikertelen tranzakciólétrehozás';
        $array[5307] = 'A kérésben megadott devizanem ("currency") nem egyezik a fiókhoz beállítottal.';
        $array[5308] = 'A kérésben érkező kétlépcsős tranzakcióindítás nem engedélyezett a kereskedői fiókon';
        $array[5309] = 'Számlázási adatokban a címzett hiányzik ("name" természetes személy esetén, "company" jogi személy esetén).';
        $array[5310] = 'Számlázási adatokban a város kötelező.';
        $array[5311] = 'Számlázási adatokban az irányítószám kötelező.';
        $array[5312] = 'Számlázási adatokban a cím első sora kötelező.';
        $array[5313] = 'A megvásárlandó termékek listájában ("items") a termék neve ("title") kötelező.';
        $array[5314] = 'A megvásárlandó termékek listájában ("items") a termék egységára ("price") kötelező.';
        $array[5315] = 'A megvásárlandó termékek listájában ("items") a rendelt mennyiség ("amount") kötelező pozitív egész szám.';
        $array[5316] = 'Szállítási adatokban a címzett kötelező ("name" természetes személy esetén, "company" jogi személy esetén).';
        $array[5317] = 'Szállítási adatokban a város kötelező.';
        $array[5318] = 'Szállítási adatokban az irányítószám kötelező.';
        $array[5319] = 'Szállítási adatokban a cím első sora kötelező.';
        $array[5320] = 'A hívó kliensprogram megnevezése,verziószáma ("sdkVersion") kötelező.';
        $array[5321] = 'Formátumhiba / érvénytelen JSON string';
        $array[5322] = 'Érvénytelen ország';
        $array[5323] = 'Lezárás összege érvénytelen';
        $array[5324] = 'Termékek listája ("items"), vagy tranzakciófőösszeg ("total") szükséges';
        $array[5325] = 'Érvénytelen URL';
        $array[5326] = 'Hiányzó cardId';
        $array[5327] = 'Lekérdezendő kereskedői tranzakcióazonosítók ("orderRefs") maximális számának (50) túllépése.';
        $array[5328] = 'Lekérdezendő SimplePay tranzakcióazonosítók ("transactionIds") maximális számának (50) túllépése.';
        $array[5329] = 'Lekérdezendő tranzakcióindítás időszakában "from" az "until" időpontot meg kell előzze.';
        $array[5330] = 'Lekérdezendő tranzakcióindítás időszakában "from" és "until" együttesen adandó meg.';
        $array[5333] = 'Hiányzó tranzakció azonosító';
        $array[5337] = 'Hiba összetett adat szöveges formába írásakor.';
        $array[5339] = 'Lekérdezendő tranzakciókhoz tartozóan vagy az indítás időszaka ("from" és "until") vagy az azonosítólista ("orderRefs" vagy "transactionIds") megadandó.';
        $array[5343] = 'Nem megfelelő tranzakcióstátusz';
        $array[5344] = 'Nem megfelelő tranzakcióstátusz';
        $array[5345] = 'Áfa összege kisebb, mint 0';
        $array[5349] = 'A tranzakció nem engedélyezett az elszámoló fiókon (AMEX, TSP)';
        $array[5350] = 'Érvénytelen email';
        $array[5351] = 'Érvénytelen nap';
        $array[5352] = 'Simple business fiók hiba / nem létező fiók';
        $array[5401] = 'Érvénytelen salt, nem 32-64 hosszú';
        $array[5413] = 'Létrejött utalási tranzakció';
        $array[5501] = 'Böngésző accept kötelező';
        $array[5502] = 'Böngésző agent kötelező';
        $array[5503] = 'Böngésző ip kötelező';
        $array[5504] = 'Böngésző java kötelező';
        $array[5505] = 'Böngésző nyelv kötelező';
        $array[5506] = 'Böngésző szín kötelező';
        $array[5507] = 'Böngésző magasság kötelező';
        $array[5508] = 'Böngésző szélesség kötelező';
        $array[5509] = 'Böngésző tz kötelező';
        $array[5511] = 'Érvénytelen böngésző accept';
        $array[5512] = 'Érvénytelen böngésző agent';
        $array[5513] = 'Érvénytelen böngésző IP cím';
        $array[5514] = 'Érvénytelen böngésző java';
        $array[5515] = 'Érvénytelen böngésző nyelv';
        $array[5516] = 'Érvénytelen böngésző szín';
        $array[5517] = 'Érvénytelen böngésző magasság';
        $array[5518] = 'Érvénytelen böngésző szélesség';
        $array[5519] = 'Invalid browser tz';
        $array[5530] = 'Érvénytelen type';
        $array[5813] = 'Kártya elutasítva';
        $array[6100] = 'a fiókon nincs engedélyezve az RTP fizetés';
        $array[6101] = 'hiányzik vagy hibás a kereskedői csomag azonosító';
        $array[6105] = 'fizető neve nincs megadva';
        $array[6107] = 'fizető email címe nemhelytelen vagy hiányzó email cím';
        $array[6108] = 'fizető bankszámlaszáma helytelen';
        $array[6123] = 'a megadott kereskedői tranzakció azonosítók száma meghaladja a maximális értéket egy csomagban';
        $array[6124] = 'a from paraméter az until paraméter-nél későbbi dátum';
        $array[6125] = 'from és until paramétereket együtt kell megadni';
        $array[6127] = 'tranzakció nem visszavonható';
        $array[6128] = 'hibás tranzakció lejárati dátum, nem lehet múltbeli';
        $array[6133] = 'közlemény (additionalInfo) túl hosszú (>140 karakter)';
        $array[6135] = 'a megadott tranzakció azonosítók száma meghaladja a maximális értéket';

        // Felvinni ezen hibákat
        foreach($array AS $key => $value) {
            SimplePayError::insertOrIgnore([
                "id" => $key,
                "message" => $value
            ]);
        }
    }
}
