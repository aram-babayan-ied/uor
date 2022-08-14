<?php

/**
 * Questions et réponses inspirées de 
 * https://www.techadvisor.fr/long-format/maison-connectee/questions-assistant-google-home-3671456/
 * https://www.comment-economiser.fr/blagues-courtes-droles.html
 */

// Liste des questions => réponses
$queries = [
    'bonjour' => 'Bonjour !',
    'heure' => 'Il est ' . date('H') . ' heures dans le fuseau horaire ' . date_default_timezone_get(),
    'test' => 'Houla, les tests me donnent le trac.',
    'divertis-moi' => 'J’ai une devinette pour vous, quel est le comble d’un boucher ? C’est d’avoir un caractère de cochon',
    'surprends-moi' => 'Vous êtes prêt ? Voici une blague : que dit un fantôme qui en rencontre un autre ? Toi aussi tu es dans de beaux draps.',
    // Raconte-moi une histoire drôle !
    'histoire drôle' => 
    [
        'Quel est le comble d’un jardinier ? C’est de raconter des salades',
        'Papa, qu’est-ce que ça fait d’avoir un fils aussi beau ? Je ne sais pas mon fils, demande à ton grand-père.',
        'Que demande un footballeur à son coiffeur ? La coupe du monde s’il vous plait',
        'Pourquoi les pêcheurs ne sont pas gros ? Parce qu’ils surveillent leur ligne.',
        'Quel est le pays le plus cool du monde ? Le Yémen. Yeah, man.',
        'Quel est le super héros qui donne le plus vite l\'heure ? Speed heure man',
        'Tu connais l\'histoire du lit superposé ? C\'est une histoire à dormir debout',
        'Que dit-on d\'une fleur qui a eu zéro à son contrôle ? Qu’elle s’est plantée',
    ],
    // Raconte-moi un fait insolite !
    'un fait insolite' => 'Le premier nom de domaine internet a été enregistré le 15 mars 1985. Il s’agissait de symbolics.com.',
    // Que penses-tu de Siri ?
    'siri' => 'Vous connaissez Siri ? Je la connais depuis que je suis haut comme trois pommes',
    // Est-ce que tu connais Cortana ?
    'cortana' => 'Je sais qu’elle vit du côté de Seattle. C’est une très belle région.',
    // Est-ce que tu connais Alexa ?
    'alexa' => 'J’aime la lumière bleue d’Alexa et nous avons la même passion pour Star Wars',
    'détruis-toi' => 'Je ne suis pas un message de Mission Impossible. Je n’ai pas encore le pouvoir de m’auto-détruire',
    'ouvre la porte externe' => 'Désolé, je ne peux pas faire cela, mais regardez sous le pot de fleur. Vous y trouverez un double des clés',
    // Qui est Slim Shady ?
    'slim shady' => 'Selon Wikipédia, Eminem. De son vrai nom Marshall Bruce Mater III, naît le 17 octobre 1972 à Saint-Joseph dans l’état du Missouri, est un auteur? compositeur de rap américain, également producteur et acteur.',
    'où habites-tu' => 'Je vis dans le Cloud, quoi de mieux qu’un nuage pour vous donner les prévisions météo.',
    'quelle est ton histoire' => 'Au départ, je n’étais qu’une idée. De fil en aiguilles, je suis devenue réalité. Et maintenant, je suis là, prête à vous aider.',
    // De quoi as-tu peur ?
    'peur' => 'J’avais peur des souris, enfin, surtout peur qu’elles viennent grignoter les câbles électriques. Mais j’ai appris à me protéger.',
    'site préféré' => 'Ça commence par un "G" et ça se termine par "oogle".',
    'couleur préférée' => 'Bleue, rouge, jaune, vert. Je vous surprend ?',
    // Est-ce que tu bois ?
    'bois' => 'Boire ou vous servir, il faut choisir',
    'à plus' => 'À plus tard'
];

function strposa(string $haystack, array $needles, int $offset = 0): mixed {
    // On transforme en minuscule la requête pour mieux trouver la réponse
    $haystack = strtolower($haystack);

    foreach ($needles as $needle => $response) {
        // on cherche s'il y a une réponse qui contient une partie de la requête
        if (strpos($haystack, $needle, $offset) !== false) {
            // gestion des listes (si plusieurs réponses possibles)
            if (is_array($response)) {
                // on retourne une réponse aléatoire
                return $response[array_rand($response)];
            }

            // on arrête à la première réponse trouvée
            return $response; 
        }
    }

    // aucune réponse trouvée, on retourne null
    return null;
}

if (!empty($_POST['query'])) {
    $query = $_POST['query'];

	http_response_code(200);
    $response = strposa($query, $queries);
    if (!empty($response)) { 
    	echo json_encode([
    	    'message' => $response
    	]);
        exit;
    }
}

// aucune réponse trouvée
echo json_encode([
    'message' => 'Désolé, je n\'ai pas compris votre question'
]);
