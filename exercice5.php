<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=uor', 'root', '');

	// Traitement de l'envoi du formulaire de demande de contact
    if (!empty($_POST['contact'])) {
    	$post = $_POST['contact'];

    	// Règles de saisie
	    $formRules = [
			'firstname' => [
				'title' => 'Prénom',
				'required' => true,
				'maxlength' => 128,
			],
			'lastname' => [
				'title' => 'Nom',
				'required' => true,
				'maxlength' => 128,
			],
			'email' => [
				'title' => 'E-mail',
				'required' => true,
				'maxlength' => 128,
				'validator' => 'email',
			],
			'phone' => [
				'title' => 'Numéro de téléphone',
				'required' => true,
				'maxlength' => 16,
				'validator' => 'phone',
			],
			'title' => [
				'title' => 'Titre',
				'required' => true,
				'maxlength' => 128,
			],
			'message' => [
				'title' => 'Message',
				'required' => true,
				'maxlength' => 4096,
			],
	    ];

		// Vérification des règles de saisie
		$errors = [];
		$datas = [];
	    foreach ($formRules as $field => $rule) {
	    	// Vérification des champs vides
    		if (!empty($rule['required']) && empty($post[$field])) {
				$errors[$field] = 'Le champ ' . $rule['title'] . ' ne peut pas être vide.';
				continue;
    		}

			// Vérifications des champs du type email
    		if (isset($rule['validator']) && $rule['validator'] === 'email' 
    			&& !filter_var($post[$field], FILTER_VALIDATE_EMAIL)
    		) {
				$errors[$field] = 'Le champ ' . $rule['title'] . ' n\'est pas valide.';
				continue;    		
			}

			// Vérifications des champs du type numéro de téléphone
    		if (isset($rule['validator']) && $rule['validator'] === 'phone' 
    			&& !preg_match('/^((\+)33|0|0033)[1-9](\d{2}){4}$/', $post[$field])
    		) {
				$errors[$field] = 'Le champ ' . $rule['title'] . ' n\'est pas valide.';
				continue;    		
			}

			// Vérifications de la longueur de texte
    		if (isset($rule['maxlength']) && strlen($post[$field]) > $rule['maxlength']) {
				$errors[$field] = 'Le champ ' . $rule['title'] . ' ne peut pas dépasser ' . 
					$rule['maxlength'] . ' caractères';
				continue;
			}

			$datas[$field] = $post[$field];
	    }

	    if (empty($errors)) {
	    	$datas['datetime'] = date('Y-m-d H:i:s');

			// Transmission de la demande de contact à la base de données
			$stmt = $pdo->prepare(
				"INSERT INTO `contacts` (`firstname`, `lastname`, `email`, `datetime`, `phone`, `title`, `message`) 
				VALUES (:firstname, :lastname, :email, :datetime, :phone, :title, :message)"
			);
			$stmt->execute($datas);
	    }
    }

		// Lecture des demandes de contact depuis la base de données
    $contactList = $pdo->query('SELECT * from `contacts` ORDER BY `datetime` DESC');
} catch (PDOException $e) {
    print "Une erreur est survenue lors de la connexion à la base de données MySQL : " . $e->getMessage() . "<br/>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>CV Aram BABAYAN - Développeur Web full stack à Paris</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Découvrez le site CV de Aram BABAYAN - Développeur Web full stack à Paris. Consultez mes compétences, mon parcours et mes réalisations."/>
	<meta property="og:locale" content="fr_FR" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="CV Aram BABAYAN - Développeur Web full stack" />
	<meta property="og:description" content="Découvrez le site CV de Aram BABAYAN - Développeur Web full stack à Paris. Consultez mes compétences, mon parcours et mes réalisations." />
	<meta property="og:site_name" content="Site CV Aram BABAYAN - Développeur Web full stack" />
	<meta property="article:published_time" content="2022-07-21T17:36:08+00:00" />
	<meta property="article:modified_time" content="2022-07-21T17:36:08+00:00" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
<body>

<header>
	<div class="p-3 bg-dark text-white">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
					CV Aram BABAYAN
				</a>

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="./exercice2.html" class="nav-link px-2 text-secondary">Exercice 2</a></li>
					<li><a href="./exercice3.html" class="nav-link px-2 text-secondary">Exercice 3</a></li>
					<li><a href="./exercice5.php" class="nav-link px-2 text-white">Exercice 5</a></li>
					<li><a href="./exercice6.php" class="nav-link px-2 text-secondary">Exercice 6</a></li>
				</ul>
			</div>
		</div>
	</div>

</header>
<article class="container">

	<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
		<a href="#" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
			Exercice 5
		</a>

		<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
			<li><a href="#about" class="nav-link px-2 link-dark">A propos de moi</a></li>
			<li><a href="#skills" class="nav-link px-2 link-secondary">Compétences techniques</a></li>
			<li><a href="#achievements" class="nav-link px-2 link-secondary">Mes réalisations</a></li>
			<li><a href="#gallery" class="nav-link px-2 link-secondary">Portfolio</a></li>
			<li><a href="#hobbies" class="nav-link px-2 link-secondary">Centres d’interêt</a></li>
			<li><a href="#languages" class="nav-link px-2 link-secondary">Langues</a></li>
			<li><a href="#contact" class="nav-link px-2 link-secondary">Contact</a></li>
		</ul>
	</header>

	<h1 class="pb-3">Exercice 5</h1>

	<section id="about" class="pt-3">
		<h2 class="pb-3">A propos de moi</h2>
		<p>
			Je m'appelle Aram Babayan et j'exerce le metier de développeur web depuis 2013 suite à un apprentissage
			autodidacte depuis 2008.
		</p>
		<p>
			Passioné par l'univers du web je me suis consacré dès mon plus jeune âge à l'apprentissage du 
			développement web et la gestion des serveurs Linux.<br>
			J'ai eu la chance d'avoir des connaissances (étudiants en informatique) qui m'ont introduit dans 
			ces domaines en commançant par la création des serveurs de jeux video en local (Enemy Territory, Counter 
			Strike, Team Speak 3...) et à distance sur des serveurs VPS Linux, puis des sites internet/forums des serveurs 
			de jeu basant sur des CMS PHP (d'abord PHP-Fusion, puis PhpBB, MyBB, vBulletin) avant de m'offrir quelques 
			livres de PHP/MySQL/Linux/Bash afin de tenter de réaliser moi même ce genre de solutions (mais très basiques).
			<br>
		</p>
		<p>
			Cela m'a permis d'apprendre moi même le langage PHP et de changer totalement ma passion d'enfance des jeux
			vidéo par l'envie d'apprendre tous les concepts techniques des sites web, dès la création d'un site jusqu'à
			l'envie de savoir comment les plus grands sites comme google.com arrivent à gérer un trafic très important à grande 
			échelle (ou des attaques DDoS de très grande fréquence/capacité) sans interruption, donc notamment la création 
			et la gestion des infrastructures scalables de haute disponibilité.
		</p>
		<p>
			Après quelques réalisations en PHP de sites vitrines internet très simples pour des entreprises en Irlande et
			en Pologne (sites vitrines responsive avec une galerie photo dynamique, formulaires de contact + backoffice)
			j'ai decidé en 2014 à l'âge de 18 ans de me lancer professionnellement et de créer une activité juridique 
			<a href="http://linuxic.com/">LINUXIC EURL</a> avec l'idée d'offrir le service d'un hébergement web encore plus
			automatisé et plus simplifié (par exemple lors de l'achat d'un hébergement web et d'un nom de domaine - la
			configuration entre les 2 services - les DNS et le Virtual Host était faite automatiquement sans intervention
			manuelle de l'utilisateur).<br>
			En 2015 j'ai réussi à obtenir l'accord de LINUX FOUNDATION pour l'usage de la marque Linux® dans les noms de
			mes produits (par exemple Serveur VPS Linux®).
		</p>
		<p>
			Un autre service que je souhaitais offrir c'est la création des comptes (adresses) e-mail personnalisés avec
			son nom de domaine dédié sans aucune connaissance technique nécessaire (juste pouvoir renseigner une
			adresse@nom-de-domaine.extension, vérifier la disponibilité du nom de domaine et pouvoir le commander avec
			tout le process de création/configuration entièrement automatisé : 
		</p>
		<ul>		
			<li>création du nom de domaine auprès du registre concerné,</li>
			<li>création du compte email sur un serveur email</li>
			<li>liaison des DNS entre le nom de domaine et le serveur mail,</li>
			<li>ajout des enregistrements DNS SPF/DKM/DMARC pour tenter d'éviter de tomber dans le SPAM....</li>
		</ul>
		<p>
			J'ai commencé en utilisant une solution existante <a href="https://www.whmcs.com/">WHMCS</a> pour gérer la
			partie facturation/commandes et
			partiellement la liaison avec <a href="https://www.directadmin.com/">DirectAdmin</a> /
			<a href="https://cpanel.net/">cPanel</a> mais elle n'était pas suffisante (pas assez de liaisons avec
			des solutions tierces), j'ai donc passé 6 mois sans arrêt à implementer avec le
			<a href="https://www.yiiframework.com/">framework
				PHP MVC Yii2</a> mon propre système e-commerce multi-langue (FR/EN/PL/ES) et multi-devise (EUR/PLN) en liaison
			avec les API's de gestion des services - API's de OVH (liaison avec le registre des noms de domaines),
			API SolusVM (création/gestion des serveurs virtuels), API cPanel + DirectAdmin (création/gestion des comptes
			de l'hébergement web + services email) tous ces services paramètrables depuis l'espace client unique de mon
			projet LINUXIC, contrairement aux autres hébergeurs qui avaient très souvent des interfaces totalement
			distinctes pour chaque service et difficiles à retrouver (un site de facturation, cPanel hébergement web,
			noms de domaines DNS, un autre site pour la gestion des VPS...).
		</p>
		<p>
			Passioné énormement par les infrastructures scalables et en rêvant de réaliser un jour une infrastructure
			scalable pour mes clients LINUXIC (en cas de besoin) j'ai décidé de réaliser une petite infrastructure de test
			(DNS round-robin, HAProxy, MySQL replication) qui m'a obligé d'appliquer également un système de load
			balancing des sessions pour éviter la perte des sessions PHP en fonction du serveur web servi par HAProxy ou
			DNS round robin).
		</p>
		<p>
			Suite à multiples tentatives de marketing du projet (SEA - Google Ads, Microsoft Ads, Facebook Ads) mon projet 
			LINUXIC était un échec commercial. Le marché de l'hébergement web était trop saturé (notamment au niveau du 
			référencement naturel) et le trafic payant était trop cher par rapport à la valeur ajoutée.
		</p>
		<p>
			Malgré un retour sur investissement negatif et malgré que j'ai consacré plusieurs années sans réussite ce projet
			m'était très utile car il m'a permis d'apprendre énormement de choses en pratique dans beaucoup de domaines.<br>
			J'ai gardé ce projet pendant 6 ans sans évolutions techniques supplémentaires en tant que l'activité secondaire
			en servant un petit nombre de clients et mon activité principale sont devenues les prestations en développement web.
		</p>
		<p>
			Entre les années 2016 et 2019 j'ai réalisé à partir des cahiers de charge fournis par les clients une dizaine de 
			projets client (entre 2 000 et 25 000 lignes de code chaque projet) en utilisant quasi toujours des frameworks PHP
			(<a href="https://www.yiiframework.com/">Yii2</a>, <a href="https://laravel.com/">Laravel</a>,
			<a href="https://symfony.com/">Symfony</a>), jQuery, HTML5, CSS3 (Bootstrap, ...). J'ai également réalisé 2
			applications mobiles natives iOS et Android en Swift 3 et Java. L'envie d'apprendre le développement des
			applications iOS m'a obligé d'investir sur un iMac et depuis ce temps je me suis habitué à utiliser que le
			système MacOS même pour le développement web (raccourcis, macro, snippets...).
		</p>
		<p>
			Ensuite en avril 2019 après 6 ans d'activité professionnelle j'ai décidé que je devrais apprendre à travailler 
			en équipe et en gardant mon activité LINUXIC toujours active après 3 entretiens techniques j'ai été embauché en
			tant que développeur web full stack dans une entreprise en region parisienne dans laquelle je travaille
			toujours à plein temps et qui m'a permis d'apprendre les bases de données non relationnelles NoSQL
			(Firebase), faire connaissance avec plus de frameworks JS back/front (NodeJS, ReactJS) et m'orienter encore
			plus vers des infrastructures cloud (AWS EC2, GCP Firebase Realtime/Storage...) et les outils d'automatisation DevOps
			(CI/CD - Github Action, Terraform, SonarQube, Grafana...).
		</p>
	</section>

	<section id="skills" class="pt-3">
		<div class="row">
			<div class="col-md-12">
				<h2>Compétences techniques</h2>
				<ul class="p-3">
					<li>TWIG, HTML5, CSS3, Responsive Design</li>
					<li>JavaScript (jQuery/UI, ReactJS, NodeJS)</li>
					<li>PHP orienté objet, MVC : Symfony 2/3/4, Yii 2, Laravel</li>
					<li>Doctrine, Active Record</li>
					<li>NoSQL (Firebase), SQL, MySQL</li>
					<li>Android / iOS (bases en développement Java et Swift)</li>
					<li>Web Services (REST API / SOAP)</li>
					<li>Adobe Photoshop, Sketch, Gimp</li>
					<li>Webpack, yarn, npm, composer</li>
					<li>Git, Bitbucket</li>
					<li>Github Action / Gitlab CI / Jenkins / Grafana</li>
					<li>AWS EC2 / RDS / Route53 / Bind9</li>
					<li>GCP Firebase Realtime / Storage</li>
					<li>MacOS et environnement Linux (+ Shell)</li>
				</ul>
			</div>
		</div>

	</section>

	<section id="achievements" class="pt-3">
		<h2 class="pb-3">Mes réalisations</h2>
		<table class="table table-responsive">
			<tr>
				<th class="text-break">Nom de domaine</th>
				<th>Description</th>
				<th class="d-none d-sm-table-cell">Année(s)</th>
			</tr>
			<tr>
				<td class="text-break"><a href="https://web.archive.org/web/20160612074541/http://tinytim.ie/">tinytim.ie</a></td>
				<td>Première réalisation complète de site internet en PHP</td>
				<td class="d-none d-sm-table-cell">2013</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://linuxic.com/">linuxic.com</a></td>
				<td>Hébergement web automatisé (projet personnel)</td>
				<td class="d-none d-sm-table-cell">2015</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://ips.lxc.fr/">jessie.fr ou ips.lxc.fr (preprod)</a></td>
				<td>Site internet de l’entreprise IPS (le site n'a plus été maintenu après 2019)</td>
				<td class="d-none d-sm-table-cell">2016</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://webeev.fr/">webeev.fr</a></td>
				<td>Classement de sites internet</td>
				<td class="d-none d-sm-table-cell">2016</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://foot-direct.fr/">foot-direct.fr</a></td>
				<td>Calendrier et live score des matchs de foot</td>
				<td class="d-none d-sm-table-cell">2017</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://biznessful.com/">biznessful.com</a></td>
				<td>Mise en relation de porteurs de projet avec des investisseurs</td>
				<td class="d-none d-sm-table-cell">2016, 2017, 2018 et 2019</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://soyoutv.com/">soyoutv.com</a></td>
				<td>Programme TV Direct</td>
				<td class="d-none d-sm-table-cell">2018</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://ipagination.com/">ipagination.com</a></td>
				<td>Modification de la boutique iPagination.com</td>
				<td class="d-none d-sm-table-cell">2018</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://easylitiges.fr/">easylitiges.fr</a></td>
				<td>Réalisation de l’API et de site internet mobile iOS (webview)</td>
				<td class="d-none d-sm-table-cell">2019</td>
			</tr>

			<tr>
				<td class="text-break"><a href="https://espaceclient.francebieres.fr/">espaceclient.francebieres.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>FRANCE BIERES BOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2019</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://espaceclient.montanerpietriniboissons.fr/">espaceclient.montanerpietriniboissons.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>GROUPE MONTENER PIETRINI BOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2019 - 2022</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://plus.rouquette.com/">plus.rouquette.com</a></td>
				<td>Solution de prise de commandes B2B pour <strong>GROUPE ROUQUETTE</strong></td>
				<td class="d-none d-sm-table-cell">2019</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://espaceclient.ouestboissons.fr/">espaceclient.ouestboissons.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>OUEST BOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2019</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://proxiboissons.fr/">proxiboissons.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>PROXIBOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2019</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://david-boissons.com/">david-boissons.com</a></td>
				<td>Solution de prise de commandes B2B pour <strong>DAVID BOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2019 - 2022</td>
			</tr>
		 	<tr>
		 		<td class="text-break"><a href="https://brasserie-bedague.com/">brasserie-bedague.com</a></td>
		 		<td>Solution de prise de commandes B2B pour <strong>BRASSERIE BEDAGUE</strong></td>
		 		<td class="d-none d-sm-table-cell">2019 - 2022</td>
		 	</tr>
			<tr>
				<td class="text-break"><a href="https://ccb-vins.com/">ccb-vins.com</a></td>
				<td>Solution de prise de commandes B2B pour <strong>CHAI CHATEAU BLANC</strong></td>
				<td class="d-none d-sm-table-cell">2019 - 2022</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://groupe-cerclevert.fr/">groupe-cerclevert.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>GROUPE CERCLE VERT</strong></td>
				<td class="d-none d-sm-table-cell">2020 - 2022</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://mesboissonsalamaison.fr/">mesboissonsalamaison.fr</a></td>
				<td>Solution de prise de commandes pour les particuliers (en Drive / Livraison) multi-grossiste</td>
				<td class="d-none d-sm-table-cell">2020 - 2022</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://clicknschluck.fr/">clicknschluck.fr</a></td>
				<td>Solution de prise de commandes pour les particuliers (en Drive / Livraison)</td>
				<td class="d-none d-sm-table-cell">2020 - 2022</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://ebams.fr/">ebams.fr</a></td>
				<td>Solution de prise de commandes pour les particuliers (en Drive / Livraison)</td>
				<td class="d-none d-sm-table-cell">2020 - 2022</td>
			</tr>			<tr>
				<td class="text-break"><a href="https://boutique.lexplorateurdugout.com/">boutique.lexplorateurdugout.com</a></td>
				<td>Solution de prise de commandes B2B pour <strong>EXPLORATEUR DU GOÛT</strong></td>
				<td class="d-none d-sm-table-cell">2021</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://sobcal.fr/">sobcal.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>SOBCAL</strong></td>
				<td class="d-none d-sm-table-cell">2021</td>
			</tr>
			<tr>
				<td class="text-break"><a href="https://espaceclient.dab-boissons.fr/">espaceclient.dab-boissons.fr</a></td>
				<td>Solution de prise de commandes B2B pour <strong>DAB BOISSONS</strong></td>
				<td class="d-none d-sm-table-cell">2022</td>
			</tr>
		 	<tr>
		 		<td class="text-break"><a href="https://espaceclient.click-boissons.fr/">espaceclient.click-boissons.fr</a></td> 
		 		<td>Solution de prise de commandes B2B pour <strong>CLICK BOISSONS</strong></td>
		 		<td class="d-none d-sm-table-cell">2022</td>
		 	</tr>
		 	<tr>
		 		<td class="text-break"><a href="https://espaceclient.lacaveatitoune.fr/">espaceclient.lacaveatitoune.fr</a></td> 
		 		<td>Solution de prise de commandes B2B pour <strong>LA CAVE A TITOUNE</strong></td>
		 		<td class="d-none d-sm-table-cell">2022</td>
		 	</tr>
			<tr>
				<td class="text-break"><a href="https://clicknschluck.goot.fr/">clicknschluck.goot.fr</a></td>
				<td>Solution de prise de commandes pour les particuliers (en Drive / Livraison) v2</td>
				<td class="d-none d-sm-table-cell">2022</td>
			</tr>
		</table>
	</section>

	<section id="portfolio" class="pt-3">
		<h2 class="pb-3">Portfolio</h2>
		<div class="row">
			<div class="col-md-4">
				<a href="images/mockup1.jpg">
					<img src="images/mockup1.jpg" class="rounded d-block w-100 pb-4" alt="réalisation foot-direct.fr">
				</a>
			</div>
			<div class="col-md-4">
				<a href="images/mockup2.jpg">
					<img src="images/mockup2.jpg" class="rounded d-block w-100 pb-4" alt="réalisation soyoutv.com">
				</a>
			</div>
			<div class="col-md-4">
				<a href="images/mockup3.jpg">
					<img src="images/mockup3.jpg" class="rounded d-block w-100 pb-4" alt="réalisation espaceclient.montanerpietriniboissons.fr">
				</a>
			</div>
			<div class="col-md-4">
				<a href="images/mockup4.jpg">
					<img src="images/mockup4.jpg" class="rounded d-block w-100 pb-4" alt="réalisation clicknschluck.fr">
				</a>
			</div>
			<div class="col-md-4">
				<a href="images/mockup5.jpg">
					<img src="images/mockup5.jpg" class="rounded d-block w-100 pb-4" alt="réalisation groupe-cerclevert.fr">
				</a>
			</div>
			<div class="col-md-4">
				<a href="images/mockup6.jpg">
					<img src="images/mockup6.jpg" class="rounded d-block w-100 pb-4" alt="réalisation ebams.fr">
				</a>
			</div>
		</div>
	</section>

	<section id="hobbies" class="pt-3">
		<h2>Centres d’interêt</h2>
		<ul>
			<li>Pratiques et outils DevOps, virtualisation, infrastructure (haute performance)</li>
			<li>Apprentissage en autodidacte des outils du développement web (nouveaux frameworks / langages, solutions de monitoring)</li>
			<li>Garder la forme physique malgré un travail sédentaire</li>
		</ul>
	</section>

	<section id="languages" class="pt-3 pb-3">
		<h2>Langues</h2>
		<p>Français (courant), polonais (langue maternelle), anglais (intermédiaire), arménien (intermédiaire)</p>
	</section>

	<section id="contact" class="pt-3 pb-3">
	    <h2>Demandes de contact</h2>

		<div class="contacts pb-3">
    		<?php foreach ($contactList as $key => $contact):
    			foreach ($contact as &$field) {
					// conversion des données brutes en entités HTML pour éviter les attaques XSS
    				$field = htmlspecialchars($field, ENT_QUOTES, 'UTF-8');
    			}

    			$contact = (object) $contact
    			?>
    			<hr class="pb-1">
        		<div class="contact">
                    <div class="contact-title">
                        <strong><?= $contact->title ?></strong>

                        <div class="contact-pubdate">
                            Publié le <span><?= date('d/m/Y', strtotime($contact->datetime)) ?></span> par 
                            <a href="mailto:<?= $contact->email ?>"><?= $contact->firstname ?> <?= $contact->lastname ?></a> 
                            (tél : <a href="tel:<?= $contact->phone ?>"><?= $contact->phone ?></a>)
                        </div>
                    </div>

                    <div class="contact-message">
                        <?= $contact->message ?>
                    </div>
                </div>
    		<?php endforeach ?>
		</div>

		<hr>

		<h3 class="pt-3" id="contact-form">Contactez-moi</h3>

		<?php if (isset($_POST['contact'])) : ?>

			<?php if (!empty($errors)) : ?>
				<div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
			<?php else : ?>
				<div class="alert alert-success">Votre demande de contact a bien été prise en compte.</div>
			<?php endif ?>

		<?php endif ?>

	    <div class="send contact-content bottom">
	        <div class="contact">
	            <div class="send contact-title">
	                <div class="send contact-message">
	                    <form name="contact" method="post" action="#contact-form">
	                        <div class="mb-3">
		                        <div class="row">
		                            <div class="col-md-4">
		                                <label for="contact_firstname" class="form-label">Prénom</label>
		                                <input class="form-control" type="text" id="contact_firstname" name="contact[firstname]" value="<?= $_POST['contact']['firstname'] ?? '' ?>"  maxlength="128">
		                            </div>
		                            <div class="col-md-4">
		                                <label for="contact_lastname" class="form-label">Nom</label>
		                                <input class="form-control" type="text" id="contact_lastname" name="contact[lastname]" value="<?= $_POST['contact']['lastname'] ?? '' ?>"  maxlength="128">
		                            </div>
			                        <div class="col-md-4">
			                            <label for="contact_email" class="form-label">E-mail</label>
			                            <input class="form-control" type="email" id="contact_email" name="contact[email]" value="<?= $_POST['contact']['email'] ?? '' ?>"  maxlength="128">
			                        </div>
		                        </div>
	                        </div>
	                        <div class="mb-3">
		                        <div class="row">
			                        <div class="col-md-8">
			                            <label for="contact_title" class="form-label">Titre</label>
			                            <input class="form-control" type="text" id="contact_title" name="contact[title]" value="<?= $_POST['contact']['title'] ?? '' ?>"  maxlength="128">
			                        </div>
			                        <div class="col-md-4">
			                            <label for="contact_phone" class="form-label">Numéro de téléphone</label>
			                            <input class="form-control" type="tel" id="contact_phone" name="contact[phone]" value="<?= $_POST['contact']['phone'] ?? '' ?>"  maxlength="16">
			                        </div>
	                        	</div>
	                        </div>
	                        <div class="mb-3">
	                            <label for="contact_message" class="form-label">Votre message :</label>
	                            <textarea class="form-control" id="contact_message" name="contact[message]" maxlength="4096"><?= $_POST['contact']['message'] ?? '' ?></textarea>
	                        </div>
	                        
	                        <button class="btn btn-primary" type="submit">
	                            Ajouter
	                        </button>
	                    </form>
	                </div>
	            </div>
	        </div>
		</div>
	</section>

	<hr class="featurette-divider">
</article>

<footer class="container p-3">
	© 2022 Aram BABAYAN<br />
	Tous droits réservés
</footer>
</body>
</html>