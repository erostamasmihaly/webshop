<h3>ETM Webshop</h3>
<p>Egy olyan kis magán projekt, amin keresztül meg lehet tekinteni, hogy nagyjából milyen webes alkalmazásokat tudok jelenleg fejleszteni.</p>
<p>Egy webáruház, ahol különféle szerepkörökre bontva lehet alap feladatokat elvégezni.</p>
<h4>Anoním felhasználók:</h4> 
<ul>
    <li>Meg tudják tekinteni a termékek és az áruházak oldalait.</li>
    <li>Regisztrálni tudnak, hogy így még több funkciót el tudjanak érni.</li>
</ul>
<h4>Bejelentkezett felhasználók:</h4>
<ul>
    <li>Termékek kedvelése, amely termékek a Profil oldal is megjelennek.</li>
    <li>Profil oldalon azon személyes adatokat tudják módosítani, amelyek szükségesek az OTP SimplePay fizetés lebonyolítására.</li>
    <li>Termékeket tudnak behelyezni a kosárba és a Kosáron keresztül utólag is tudják módosítani a megvásárolandó mennyiséget, esetleg törölni a kosárba rakott terméket.</li>
    <li>OTP SimplePay rendszerén keresztül fizetés.</li>
    <li>Eddigi vásárlásainak a megtekintése.</li>
</ul>
<h4>Alkalmazott felhasználók:</h4>
<ul>
    <li>Külön adminisztrációs oldallal is rendelkeznek.</li>
    <li>Egy alkalmazott egyszerre több üzletnek is dolgozhat.</li>
    <li>Értesítéseket meg tudják nézni.</li>
    <li>Termékeket és munkaköröket létre tudnak hozni és ezeket tudják szerkeszteni.</li>
</ul>
<h4>Admin felhasználók:</h4>
<ul>
    <li>Felhasználók módosítása.</li>
    <li>Kategória csoportok és a hozzá tartozó kategóriák létrehozása, szerkesztése és sorbarendezése.</li>
    <li>Üzletek létrehozása, szerkesztése és alkalmazottak hozzárendelése az üzletekhez.</li>
</ul>
<h4>Megjegyzések:</h4>
<ul>
    <li>OTP SimplePay esetén a fejlesztői verzió van alkalmazva és a végén az IPN visszaigazolás még hiányzik.</li>
    <li>Fizetéskor még a meglévő mennyiségnél többet is meg lehet vásárolni, de később majd le lesz kezelve.</li>
    <li>Alap adatokat a Seeder tartalmaz, így a <b>php artisan db:seed</b> elindításakor felhasználók, boltok, termékek, stb... is létrejönnek.</li>
    <li>Termékek esetén a <b>public\images\setup</b> tartalmazza azon képeket, amelyek a termékekhez hozzá fog tartozni. A Seeder lefuttatásakor ezen képek kerülnek át átméretezetten a megfelelő termékekhez.</li>
    <li>Minden egyes szerepkörhöz tartozik egy-egy felhasználó a Seeder lefuttatása után:
        <ol>
            <li>Vásárló - e-mail: vasarlo@etm.hu / jelszó: Vasarlo1234</li>
            <li>Alkalmazott - e-mail: alkalmazott@etm.hu / jelszó: Alkalmazott1234</li>
            <li>Admin - e-mail: admin@etm.hu / jelszó: Admin1234</li>
        </ol>
    </li>
    <li>E-mail küldés esetén a Google fiókom e-mail címe és az alkalmazás specifikus jelszava van megadva.</li>
    <li><b>.env.example</b> tartalmazza az otthoni gépemen használt <b>.env</b> fájl aktuális tartalmát.</li>
</ul>
<h4>Készítette: Erős Tamás Mihály</h4>
<ul>
    <li>Lakóhely: Miskolc-Avas, III. ütem</li>
</ul>