-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Ápr 17. 23:00
-- Kiszolgáló verziója: 10.4.22-MariaDB
-- PHP verzió: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szte-webterv`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE DATABASE IF NOT EXISTS `szte-webterv` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `szte-webterv`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `recipe_id`, `comment`) VALUES
(26, 1, 4, 'Nagyon finom!'),
(27, 2, 4, 'Igazán laktató :)'),
(28, 1, 5, 'Az egyik legfinomabb desszert!'),
(29, 2, 5, 'Nagyon jól néz ki!'),
(30, 1, 3, 'Kicsit sok idő mire kész, de megéri!'),
(31, 2, 3, 'Én tettem rá ketchup-ot :)'),
(32, 2, 1, 'Kiadós ebéd'),
(33, 3, 4, 'Inkább elmegyek a mekibe enni'),
(34, 3, 5, 'Nekem sajnos odaégett :('),
(35, 10, 5, 'Nem baj, legközelebb jobb lesz'),
(36, 10, 1, 'Nem rossz, de én maradok a sima lángosnál :)'),
(37, 3, 1, 'Ez a legfinomabb töltöttlángos *-*'),
(38, 3, 1, 'Szerintem többször is fogok ilyet csinálni!'),
(39, 10, 3, 'Hát ez nem a legjobb'),
(40, 10, 2, 'Nekem kicsit száraz a tészta'),
(41, 3, 2, 'Könnyű elkészíteni és nagyon finom!'),
(42, 1, 2, 'Sajnos nekem odaégett, mégsem olyan könnyű mint hittem'),
(43, 1, 4, 'Megcsináltam megint és nyers maradt a hús. 1/5'),
(44, 1, 1, 'Hát megmondom az őszintét, néha jól esik egy ilyen'),
(47, 1, 3, 'Másodjára is finom volt :D'),
(48, 1, 12, 'Troll');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `inbox`
--

INSERT INTO `inbox` (`id`, `sender_id`, `receiver_id`, `message`) VALUES
(46, 2, 1, 'Szia tesztelek!'),
(47, 1, 2, 'Szia tesztelek2!'),
(48, 2, 1, 'Ez egy példa beszélgetés :D'),
(49, 2, 1, 'Itt valami hasznos infó van tesztelek2 részére'),
(50, 1, 2, 'Igazán hasznos volt, köszi :)');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  `video_url` varchar(150) NOT NULL,
  `portion` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `ingredients` text NOT NULL COMMENT 'Ingredients listed, seperated by ";\\".',
  `instructions` text NOT NULL COMMENT 'Instructions seperated by ";\\".',
  `upload_date` date NOT NULL,
  `slug` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `name`, `image_name`, `video_url`, `portion`, `time`, `ingredients`, `instructions`, `upload_date`, `slug`) VALUES
(1, 1, 'Bolognai raguval töltött lángos', 'bolognai-raguval-toltott-langos.jpg', 'https://www.youtube.com/embed/7HzQmDqhnlQ', 8, 120, '450 g burgonya (megtisztítva);450 ml tej;25 g friss élesztő;1 mk cukor;1 kg liszt;25 g só;bő olaj a sütéshez;20 ml olaj;150 g hagyma;200 g répa;150 g zellergumó;1 szál szárzeller;500 g darált sertéshús;4 gerezd fokhagyma;só, bors;300 ml passata;1 tk pirospaprika;2 tk oregánó', 'A bolognai raguval töltött lángos elkészítéséhez a krumplit kis kockákra vágjuk, és enyhén sós vízben puhára főzzük. A tejet meglangyosítjuk, az élesztőt egy tálba tesszük a cukorral, kanállal áttörjük, majd ráöntjük a langyos tejet és megvárjuk, míg kissé felfut. A lisztet és a sót egy dagasztótálba tesszük, hozzáadjuk az áttört krumplit és a tejes keveréket, majd kidagasztjuk. Letakarjuk, és langyos helyen 1 órán át kelesztjük.;A raguhoz olajat melegítünk egy serpenyőben, megdinszteljük rajta az apró kockákra vágott hagymát, hozzáadjuk a kis lyukú reszelőn lereszelt répát és zellergumót, majd a kis kockákra vágott szárzellert és további kb. 2 percig pirítjuk.;Beletesszük a darált húst is, és erős lángon 3-4 percig pirítjuk. Belereszeljük a fokhagymát, sózzuk, borsozzuk, és felöntjük a passatával. Megszórjuk a pirospaprikával, és közepes lángon kb. 10 percig főzzük. Végül belekeverjük az oregánót, és lekapcsoljuk a tűzhelyet.;A megkelt tésztát kb. 10 egyenlő részre osztjuk. Egy olajozott tálcán kör alakúra nyújtjuk olajos kézzel, 2-3 kanál ragut kanalazunk a belsejébe, félbehajtjuk, és a széleit alaposan összenyomkodjuk. 180 fokos olajban kb. 3 perc alatt készre sütjük, közben az idő felénél megfordítjuk. Konyhai papírtörlőre szedjük a kész lángosokat, és leitatjuk róluk a felesleges olajat. Tálaláskor a tetejét megszórjuk reszelt sajttal.', '2022-03-14', 'bolognai-raguval-toltott-langos'),
(2, 2, 'Az eredeti carbonara', 'az-eredeti-carbonara.jpg', 'https://www.youtube.com/embed/7jPh79AdnRk', 2, 30, '150 g füstölt kolozsvári szalonna;250 g spagetti;só, bors;80 g parmezán;2 ek olívaolaj;4 db tojás;frissen reszelt szerecsendió;150 - 200 ml tészta-főzővíz', 'A szalonnát vékony csíkokra vágjuk, és kb. 2 evőkanál olajon lassan megpirítjuk, majd elzárjuk. Közben a tésztát sós vízben al dentére főzzük, majd leszűrjük úgy, hogy egy keveset megtartunk a tészta főzővizéből.;A tojásokat felverjük, sózzuk, borsozzuk, belereszeljük a parmezánt és a szerecsendiót is.;A kifőtt tésztát beleforgatjuk a pirított szalonnába. Összerázzuk, majd ráöntjük a tojásos keveréket, a tészta főzővizét, és ha kicsit kihűlt a serpenyő, picit visszarakjuk a tűzre. Folyamatosan rázogatjuk addig, amíg az egész krémes nem lesz.', '2022-03-19', 'az-eredeti-carbonara'),
(3, 1, 'Grillezett kenyérlángos', 'grillezett-kenyerlangos.jpg', 'https://www.youtube.com/embed/UzjJ-L_HMlk', 4, 240, '350 ml szobahőmérsékletű víz;1 tk só;550 g pizzaliszt;15 g élesztő;1 tk cukor;1 ek olívaolaj;1 szál füstölt szárazkolbász;200 g tejföl;1 fej lilahagyma;100 g sajt (trappista, cheddar, amit szeretnénk);150 ml olívaolaj;friss kakukkfű;friss rozmaring;2 gerezd fokhagyma', 'A tésztához a vízbe morzsoljuk az élesztőt, hozzászórjuk a sót és a cukrot, majd átkeverjük. A lisztet egy nagy tálba szórjuk, ráöntjük az élesztős vizet, az olívaolajat, és simára dagasztjuk a tésztát. Ha szép fényes és ruganyos lesz, megszórjuk a tetejét liszttel, letakarjuk és árnyékos, hűvösebb helyen 1,5-2 órát pihentetjük.;Lisztezett deszkára borítjuk a megkelt tésztát és négy részre vágjuk. Szép kis bucikká formázzuk őket. A feltéthez a kolbászt vékony karikára, a hagymát vastagabb cikkekre vágjuk. A fokhagymás olajhoz az olívaolajba reszeljük a fokhagymát, belemorzsoljuk a kakukkfüvet és hozzáadjuk az apróra vágott rozmaringot. A tejfölt átkeverjük, a sajtot pedig lereszeljük nagylyukú reszelőn. A tésztabucikat hosszúkás alakúra nyújtjuk, megkenjük a tetejét a fokhagymás fűszeres olajjal és a megkent oldalával lefelé a grillrácsra fektetjük. Pár perc után amikor megsült a tészta alja, lekenjük a tetejét is olajjal és gyorsan megfordítjuk. Sülés közben mehetnek is rá a feltétek. Először tejföl, majd reszelt sajt, kolbászkarikák, lilahagymagerezdek és még kevés fokhagymás olaj. Amikor megsült a tészta másik fele is és ráolvadt a sajt, már ehetjük is!', '2022-01-22', 'grillezett-kenyerlangos'),
(4, 2, 'Homemade dupla sajtos hamburger', 'homemade-duplasajtos-hamburger.jpg', 'https://www.youtube.com/embed/gfgtt_fh9RA', 3, 60, '2 fej vöröshagyma;500 g darált marhahús;1 mk fokhagymapor;só, bors;1 mk zárított vöröshagyma;1 csomag lapka cheddar sajt;ketchup;3 db szezámmagos hamburgerzsömle;1 db csemegeuborka;mustár', 'A vöröshagymát félbevágjuk, felszeleteljük majd mikrohullámú sütőben, alacsony fokozaton kb. 8-10 perc alatt dehidratálom. A darált húst sózzuk, borsozzuk, hozzákeverjük a fokhagymaport és a szárított vöröshagymát, majd kézzel jól összegyúrjuk. A fűszerezett húst hat részre osztjuk, így kb. 7-8 dkg-os húspogácsákat kapunk, és egyenként, sütőpapír között, egy lábas segítségével ujjnyi vastagságúra lapítjuk. A bucikat kettévágjuk.;Egy serpenyőt kevés olajjal felhevítünk és megsütjük rajta a hamburgerpogácsákat. Ezekre kerül egy-egy szelet sajt. Az összeállításnál a kettévágott buci aljára kerül egy sajtos húspogácsa, erre még egy ebből a gyönyörűségből, majd pár szelet hagyma, és csemegeuborka karika. A bucik kalapjait beborítjuk ketchuppal és mustárral és megkoronázzuk vele a hamburgerünket.', '2022-01-22', 'homemade-dupla-sajtos-hamburger'),
(5, 3, 'Tiramisu', 'tiramisu.jpg', 'https://www.youtube.com/embed/X_GIPOtyJSo', 1, 80, '4 tk instant kávé;350 ml forró víz;100 g kristálycukor;4 db tojás;1 csipet só;500 g mascarpone;24 db babapiskóta;cukrozatlan kakaópor', 'Első lépésként feloldjuk az instant kávét forró vízben, majd átöntjük egy tálba, hogy könnyebben kihűljön és adunk hozzá a receptben szereplő cukormennyiségből kb. 2 evőkanálnyit. A tojásokat kettéválasztjuk. A tojássárgájához adjuk a maradék cukor felét és fehéredésig habosítjuk. A fehérjét egy csipet sóval tiszta habverővel elkezdjük felverni, majd hozzáadjuk a maradék cukrot és kemény habbá verjük.;A cukros tojássárgáját alaposan elkeverjük a mascarponéval, majd mehet hozzá tojásfehérjehab fele, amivel fellazítjuk a sárgájás részt, ezután lazán beleforgatjuk a hab másik felét is, ügyelve, hogy ne törjük össze a habot.;Már csak az összeállítás maradt hátra. Egy kb. 35 cm átlójú tálba rakunk egy kisebb adag krémet és elegyengetjük. A babapiskótákat 2-3 másodpercre a kávéba mártjuk és rásorakoztatjuk őket a krémre. Majd újra jön egy adag mascarponés krémréteg, rá két sor babapiskóta, majd az egészet krémmel zárjuk. Utolsó lépésként megszórjuk egy nagy adag kakaóporral és hűtőbe rakjuk, legalább 3 órára, de a legjobb egy egész éjszakát pihentetni hogy jól összeérjenek az ízek.', '2022-03-19', 'tiramisu'),
(12, 1, 'Első receptem amit feltöltök', 'rickroll.png', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 15, 144, '1 adag szeretet;2 adag zsömle;4l víz;8kg liszt;16 doboz tojás;32l tej', 'Minden készre keverünk, majd berakjuk a sütőbe.;\n\nJó étvágyat!', '2022-04-16', 'Első-receptem-amit-feltöltök');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `birthdate` date NOT NULL,
  `picture` varchar(50) NOT NULL,
  `email_is_private` tinyint(1) NOT NULL DEFAULT 0,
  `birthdate_is_private` tinyint(1) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `birthdate`, `picture`, `email_is_private`, `birthdate_is_private`, `admin`) VALUES
(1, 'tesztelek', 'teszt.elek@gmail.com', '$2y$10$jj.Al.DN60BdJ5n7qEuO/.Qkwm6BAqydySlfDS0SHZprlfiKiHpRG', '2022-03-31', '492-4929444_eating-popcorn-png-transparent-png.png', 1, 0, 0),
(2, 'tesztelek2', 'tesztelek2@gmail.com', '$2y$10$EaOC20AxuIM0vUiinCg6bOCrDYwwxFDvac9B9ZInVBrc3.nqt9eam', '2022-04-03', 'nemnyilatkozom.PNG', 0, 0, 0),
(3, 'tesztelek3', 'tesztelek3@gmail.com', '$2y$10$vKlTQdJtFmyRJaqSuiSKgObumuEy3/RCajFbU0YyVYc8qPVZVtToe', '2022-04-03', 'brian.PNG', 0, 0, 0),
(9, 'admin1', 'admin@admin.com', '$2y$10$R9yrlotN/KiLepJsvO6YSO4AvzNk1Ovxu56lbsjasjmcTiZ2fdASe', '1900-01-01', 'admin1.PNG', 0, 0, 1),
(10, 'tesztelek4', 'tesztele4@gmail.com', '$2y$10$d00.aq3/QRVdk37Z16nGU.agkhMRT4o3LsTJAvwesSJrIU1.f3Sqe', '2022-04-22', 'thomas.PNG', 0, 0, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user` (`user_id`),
  ADD KEY `comments_recipe` (`recipe_id`);

--
-- A tábla indexei `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inbox_sender` (`sender_id`),
  ADD KEY `inbox_receiver` (`receiver_id`);

--
-- A tábla indexei `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `recipes_user` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT a táblához `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT a táblához `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `inbox_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
