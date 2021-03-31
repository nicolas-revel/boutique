-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 mars 2021 à 13:01
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--
CREATE DATABASE IF NOT EXISTS `boutique` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `boutique`;

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

DROP TABLE IF EXISTS `adresses`;
CREATE TABLE IF NOT EXISTS `adresses` (
  `id_adress` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_guest` int(11) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `infos` varchar(255) DEFAULT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id_adress`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`id_adress`, `title`, `id_user`, `id_guest`, `country`, `town`, `postal_code`, `street`, `infos`, `number`) VALUES
(1, 'Appart Marseille', 2, NULL, 'France', 'Marseille', '13001', 'Rue des HÃ©ros', 'Appartement 8', 22),
(2, 'Travail', 3, NULL, 'France', 'Marseille', '13002', 'Rue d\'Hozier', NULL, 8),
(3, 'Maison', 3, NULL, 'France', 'Fuveau', '13710', 'Route departementale 96', NULL, 202),
(33, 'adresse vacances', 3, NULL, 'France', 'Marseille', '13006', 'adresse vacances', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `img_category` text,
  PRIMARY KEY (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `category_name`, `img_category`) VALUES
(1, 'Plantes', '487d42f551f047e0e9acf92cd072242d.jpg'),
(2, 'Pots &amp; ollas', '680e91563460f4efa486fd97a69c7be6.jpg'),
(3, 'Cache pots', 'aa64c39c9269ffc641e290e39e8dca7a.jpg'),
(4, 'Accessoires', '12889dd6e373892bbdf078ed553969e8.jpg'),
(5, 'Decoration', '968a7eccf871731f0538aad282638215.jpg'),
(6, 'Terrariums', '0bed2106e69d6b5a9790f41a16d869d7.jpg'),
(7, 'Terreau &amp; angrais', '2a1a1e63378dedf621234ec3b43b1dbc.jpg'),
(8, 'Librairie', 'b008df5581bce508fc5b66470fa361f4.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `date_comment` date NOT NULL,
  `content` text NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_comment`, `id_user`, `id_product`, `date_comment`, `content`, `rating`) VALUES
(1, 1, 3, '2021-02-15', 'Plante magnifique, extrêmement bien protégé pour l\'envoie, je recommande à 100%.', 5),
(2, 1, 1, '2021-02-15', 'Merci beaucoup pour cette merveille, envoie rapide! Juste une une branche s\'est cassé durant le transport mais rien de grave !', 3),
(3, 1, 2, '2021-02-15', 'Mignonette petite plante, ma tendre valentine à adorée ! Merci', 5),
(4, 1, 3, '2021-02-17', 'Au top, merci!', 5),
(5, 1, 3, '2021-02-17', 'Au top, merci beaucoup!', 5),
(6, 1, 2, '2021-02-17', 'Au top, merci!', 3),
(7, 1, 2, '2021-02-17', 'Au top', 4),
(8, 1, 2, '2021-02-17', 'Top!', 5),
(14, 3, 50, '2021-03-30', 'Je recommande à 100%.', 5),
(13, 3, 50, '2021-03-30', 'Envoie rapide, merci !', 3),
(12, 3, 49, '2021-02-28', 'Envoie rapide, merci !', 4),
(15, 3, 42, '2021-03-30', 'Envoie rapide, le terrarium était très bien emballé, parfait en décoration !', 4),
(16, 3, 42, '2021-03-30', 'Super pour offrir!', 3),
(17, 3, 48, '2021-03-30', 'Super engrais ! Envoie rapide!', 5),
(18, 3, 48, '2021-03-30', 'Mes plantes en redemande ! Au top!', 4);

-- --------------------------------------------------------

--
-- Structure de la table `guests`
--

DROP TABLE IF EXISTS `guests`;
CREATE TABLE IF NOT EXISTS `guests` (
  `id_guest` int(11) NOT NULL AUTO_INCREMENT,
  `guest_firstname` varchar(255) NOT NULL,
  `guest_lastname` varchar(255) NOT NULL,
  `guest_mail` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `infos` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id_guest`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `guests`
--

INSERT INTO `guests` (`id_guest`, `guest_firstname`, `guest_lastname`, `guest_mail`, `title`, `country`, `town`, `postal_code`, `street`, `infos`, `number`) VALUES
(1, 'Lisa', 'Sieger', 'lisa@gmail.com', 'Appart Longchamps', 'France', 'Marseille', '13005', 'Avenue Longchamp', '', 127),
(2, 'Ludivine', 'Laprevote', 'ludivine@gmail.com', 'Adresse perso', 'France', 'Marseille', '13005', 'Rue Senac', '', 65),
(3, 'Christine', 'Garagnoli', 'christine@gmail.com', 'adresse Mallemort', 'France', 'Mallemort', '13370', 'Quartier pont de la tour ', '', 152),
(4, 'Guilio', 'Duccilli', 'duccilli@gmail.com', 'Adresse Marseille', 'France', 'Marseille', '13005', 'Rue Saint-pierre', '', 56);

-- --------------------------------------------------------

--
-- Structure de la table `ordershipping`
--

DROP TABLE IF EXISTS `ordershipping`;
CREATE TABLE IF NOT EXISTS `ordershipping` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `date_order` date NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_guest` int(11) DEFAULT NULL,
  `id_adress` int(11) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `id_status` int(11) NOT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ordershipping`
--

INSERT INTO `ordershipping` (`id_order`, `date_order`, `id_user`, `id_guest`, `id_adress`, `total_amount`, `id_status`) VALUES
(1, '2021-03-30', 3, NULL, 3, 39.35, 1),
(2, '2021-03-30', NULL, 4, NULL, 50.9, 1),
(6, '2021-03-30', 3, NULL, 33, 87.9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order_meta`
--

DROP TABLE IF EXISTS `order_meta`;
CREATE TABLE IF NOT EXISTS `order_meta` (
  `id_order_meta` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id_order_meta`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_meta`
--

INSERT INTO `order_meta` (`id_order_meta`, `id_order`, `id_product`, `quantity`, `amount`) VALUES
(1, 1, 3, 1, 6.9),
(2, 1, 50, 3, 8),
(3, 2, 27, 1, 21.95),
(4, 2, 32, 1, 26.95),
(16, 4, 50, 2, 8),
(15, 4, 48, 5, 6.5),
(14, 4, 39, 1, 45),
(13, 4, 33, 1, 3.95),
(9, 4, 33, 1, 3.95),
(10, 4, 39, 1, 45),
(11, 4, 48, 5, 6.5),
(12, 4, 50, 2, 8),
(17, 6, 3, 1, 6.9),
(18, 6, 42, 1, 79),
(19, 7, 3, 5, 6.9),
(20, 7, 42, 6, 79),
(21, 8, 20, 1, 50.49),
(22, 8, 50, 1, 8),
(23, 8, 52, 1, 17);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `id_subcategory` int(11) DEFAULT NULL,
  `date_product` date DEFAULT NULL,
  `img_product` text,
  `product_availability` int(11) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id_product`, `name`, `description`, `price`, `id_category`, `id_subcategory`, `date_product`, `img_product`, `product_availability`) VALUES
(1, 'PEPEROMIA TETRAPHYLLA \'HOPE\' ⌀15CM', '<p><strong><em>Le peperomia est une plante</em></strong> utilisée en intérieur, très apprécié pour son feuillage, aussi varié que décoratif.\nLe peperomia a la particularité d’apprécier les rempotage en fin d’hiver.\nVous pourrez donc le rempoter après l’achat si vous constatez que les racines dépassent du pot et, ensuite, une fois par an en fin d’hiver.</p>', 10, 1, 1, '2021-02-13', '2d87d1ca6b23dc505aed63a2b569c364.jpg', 0),
(2, 'MINI PLANTE VERTE \'EASY CARE\' : Pot d.7cm', 'Créez un jardin de mini plantes vertes à la maison ! Le Dieffenbachia est une plante vivace persistante, fortement appréciée pour son feuillage très décoratif panaché de blanc crème et de vert. Le dracaena (dracéna), ou dragonnier, est souvent utilisé comme plante verte d\'intérieur, appréciée pour son feuillage persistant lancéolé et arqué, souvent panaché.', 5.5, 1, 1, '2021-02-13', '36710e863f9a7de736d2ce7e5feee567.jpg', 0),
(3, 'ECHEVERIA x \'PURPLE PEARL\' : H 15 cm Pot d. 12 cm', '<p><strong><em>Un peu de culture</em></strong></p>\n<p>Le genre Echeveria comprend environ <strong>150 espèces</strong>, originaires du <em>Mexique</em>, d\'<em>Amérique centale</em> et du <em>Nord-Ouest de l\'Amérique du Sud</em>. <strong><em>Echeveria \'Purple Pearl\'</em></strong> est une mutation de \' Perle von Nurnberg \', variété horticole hybride, résultat du croisement de deux espèces, Echeveria gibbiflora \' Metallica \' et Echeveria protosina.</p>\n<p><strong><em>Pourquoi acheter ce produit ?</em></strong></p>\n<ul>\n<li>Adaptée pour les petits appartements</li>\n<li>Un moyen simple d\'amener de la couleur</li>\n</ul>', 6.9, 1, 1, '2021-02-13', '4aa290581bc776493deec07cbd60a762.jpg', 0),
(4, 'PARTHENOCISSUS QUINQUEFOLIA &quot;YELLOW WALL\' ® : Conteneur 3 litres', 'Le genre Parthenocissus (Vigne vierge) comporte environ 10 espèces, originaires d\'Amérique du Nord et d\'Asie. Parthenocissus quinquefolia (Vigne vierge vraie) est l\'une de ces espèces, originaire d\'Amérique du Nord. \'Yellow Wall\' est une variété horticole. Cette plante grimpante (ou rampante) ligneuse très vigoureuse, à croissance rapide, possède des vrilles non adhésives qui ne s\'accrochent pas seules au support et nécessitent un palissage régulier.', 21.95, 1, 2, '2021-02-15', '452c5f40965b415dd5e28deb20c8fa88.jpg', 0),
(5, 'PARTHENOCISSUS VEITCHII ROBUSTA : Conteneur 3 litres', '<p>Grimpante ligneuse, très vigoureuse à croissance rapide, Parthenocissus tricuspidata est la vigne vierge la plus connue et la plus plantée. Elle s\'accroche seule au support à l\'aide de ses courtes vrilles terminées par des ventouses. Ses feuilles caduques, entières ou trilobées, à bords fortement dentées, mesurent 10 à 20 cm de long. Le feuillage printanier est rougeâtre puis verdit au fil des semaines pour prendre en automne des coloris flamboyants mêlant le jaune, le rouge et l\'orangé.</p>', 21.95, 1, 2, '2021-02-15', '7d397cdf8b0420f6cb1f8192d9d1e480.webp', 0),
(6, 'HEDERA GLOIRE DE MARENGO : Conteneur 6L', 'Hedera canariensis est une espèce peu rustique qui se cultive de préférence en véranda ou à l\'intérieur hors climat doux (mais aussi balcon citadin et cour bien protégés). Ce lierre se caractérise par un développement important, une croissance rapide et des grandes feuilles triangulaires, à 3 ou 5 lobes faiblement marqués, de 14 cm de long sur 8 cm de large en moyenne. Portées par des rameaux et des pétioles rougeâtres, elles sont vert vif et foncent au fil du temps. \'Gloire de Marengo\' est un cultivar très populaire, souvent utilisé en fleuristerie. Ses grandes feuilles sont légèrement bombées, marbrées de gris-vert et bordées d\'une marge blanc crème irrégulière.', 34.95, 1, 2, '2021-02-15', 'f26dc95689f975b519bc88e2af411ef5.jpg', 0),
(7, 'CLIVIA : H.50cm pot', 'Vivace herbacée à souche bulbeuse.\r\n\r\nNe laissez pas les graines se former, cela compromet la floraison suivante. Dès que les hampes florales apparaiissent, n\'augmentez surtout pas l\'arrosage, sous peine de provoquer l\'avortement de la floraison. Variegata, aux feuilles rayées longitudinalement de crème; Aurea à fleurs jaunes (assez rare); Clivia miniata var. citrina, à fleurs jaune pâle; Clivia nobilis, aux fleurs en trompettes étroites, jaunes et rouges', 12.9, 1, 3, '2021-02-15', 'fc17b29c3d381c5cb16b86b1df60b151.jpg', 0),
(8, 'ARUM : C3L', 'Les arums colorés (parfois nommés Callas) sont issus de travaux d\'hybridation du Zantedeschia rehmanii, une vivace rhizomateuse sud-africaine gélive. Comme leur parente, ils forment une touffe de feuilles allongées, vert foncé maculé de points argentés.', 16.95, 1, 3, '2021-02-15', 'ce338f656fb5b90b6370b09c75b9833c.jpg', 0),
(9, 'NARCISSE TÊTE A TÊTE : godet Ø 9 cm', 'Les narcisses sont des plantes bulbeuses, les fleurs sont formées d\'une trompette centrale ou couronne émergeant d\'un ensemble de 6 pétales, le narcisse \'Tête à tête\' est une variété à petites fleurs jaunes.', 2.95, 1, 3, '2021-02-15', '03f7bab9509ee60d08492b97c2babb6a.jpg', 0),
(11, 'POT EN TERRE CUITE H40xD30cm', 'Pot en terre cuite : Hauteur = 40cm et Diamètre = 30cm', 25, 2, 4, '2021-02-15', 'da33af176e8e1cf50cae07b31bfe5ee7.jpg', 0),
(12, 'POT ELHO GREENVILLE', 'La collection greenville montre que design élégant, fonctionnalité et durabilité peuvent aller de pair ! Les pots greenville ont le look, possèdent un réservoir d’eau intégré et sont fabriqués avec du plastique recyclé. Le tout se marie parfaitement ET s’intègre bien dans votre jardin, sur votre balcon ou terrasse. Et ce, tout au long de l\'année, car ces produits sont également résistants au gel et aux UV.', 15, 2, 4, '2021-02-15', '2cd7585bbc9700d9cce60a931ed5a9b3.jpg', 0),
(13, 'OLLAS', '<p>Creuser un trou au milieu de la surface à irriguer Enterrer l\'Ollas jusqu\'au trait Remplir l\'Ollas d\'eau Fermer avec le bouchon Remplir tous les 4-6 jours</p>', 25, 2, 4, '2021-02-15', '314939cec26540bf4ec4a4a3298194e7.jpg', 0),
(14, 'JARDINIÈRE TOSCANE', 'Avec cette superbe Jardinière Toscane, mettez vos fleurs en valeur sur votre balcon ou votre rebord de fenêtre.\r\nEn polypropylène, matière légère et robuste, elle saura apporter une touche d´élégance à votre terrasse ou à votre balcon.', 10.75, 2, 5, '2021-02-15', 'b5fa91d85315edc7d658143db9238192.jpg', 0),
(15, 'JARDINIÈRE BOIS MÉTIS RECTANGLE', 'La jardinière bois Métis de forme rectangulaire est un aménagement idéal pour votre jardin ! Sa grande taille vous permet de mixer les végétaux (herbes aromatiques ou plantes), de créer un bac à fleurs afin d’égayer votre jardin ou un carrée potager afin d’aménager votre extérieur en toute simplicité et modernité !\r\n\r\nPour créer un espace convivial dans votre jardin, optez pour la gamme de bancs en bois modulables Métis et composez votre jardinière comme vous le souhaitez !\r\n\r\nVotre jardinière est livrée montée, il ne vous restera plus qu’à y placer la bâche tissée de protection.\r\n\r\nElle vous sera livrée dans un colis de 53 kg aux dimensions longueur 1 m x profondeur 0,54 m x hauteur 0,43 m.', 195, 2, 5, '2021-02-15', '8f8e6cdd2bd2cee8f1348da3d854642a.jpg', 0),
(16, 'JARDINIERES HAUTES EN BOIS RECYCLE \'LOFTY\' (Lot de 2)', 'Cette jardinière en bois sera un excellent choix pour les amateurs de jardinage afin de décorer leurs jardins, balcons ou patios. La jardinière a un design simple et ajoutera une touche de couleur naturelle à votre espace de vie extérieur. La jardinière est assez profonde et large pour contenir une grande quantité de terre et fournir suffisamment d\'espace pour vos plantes, légumes, herbes et fleurs. Fabriqué en bois', 151.99, 2, 5, '2021-02-15', '2776fba18cf65a9358ea229b688f7287.jpg', 0),
(17, 'POT XXL TOSCANE - Carré - 43,3 x 43,3 x H 80 cm - 98 L - Gris anthracite', 'Un pot de fleur carré XXL Toscane en polypropylène. Robuste, résitant au gel et aux UV. Ce pot de fleur fabriqué en France peut être utilisé en intérieur comme en extérieur. Les + de ce pot de fleur : - Résistant contre le gel et les UV - Zone de rétention d\'eau - Pré-perçage du pot de fleur - Résistant aux chocs', 32.99, 2, 6, '2021-02-15', '0422e7680ee84d4fd859c3420d860398.jpg', 0),
(18, 'POT XXL EN BOIS DE TECK carré L58 x l58 x H58 cm', 'Jardinière cubique à l\'apparence brute singulière, le pot en bois de teck carré deviendra aisément un élément fort de votre décoration, au coeur de votre jardin ou sur votre terrasse. La nature du bois lui permet de faire l\'impasse sur le moindre traitement supplémentaire, il est fait pour résister aux conditions extérieures.', 289.99, 2, 6, '2021-02-15', 'c9f430cf0de41b1e681c99cf841c4f9c.jpg', 0),
(19, 'SET DE 3 POTS OEUFS SUPER XXL STRIES BEIGE', '3 Pots forme Oeufs SUPER XXL Striés de couleur BEIGE en TERRAFIBRE.\r\n\r\nDimensions des 3 pots :\r\n\r\n1 pot 70x70x74 + 1 pot 88x88x93 + 1 POT 110X110X115', 1932, 2, 6, '2021-02-15', '72e2524a0ee7a3f4bd588c80149aa059.jpg', 0),
(20, '3 CACHE-POTS SUSPENDUS CASK - DORÉ', 'Vos plantes seront vite mises en valeur avec ces trois cache-pots suspendus élégants et design.FICHE TECHNIQUE- Cache-pots en fer.- Lot de 3.', 50.49, 3, 7, '2021-02-15', 'c986ca88b6fb8e126517fffb7cddd7f5.jpg', 0),
(21, 'CACHE-POT-SUSPENDU \'SANYA\'', 'Le cache-pot suspendu Sanya. Idéal pour accueillir et mettre en scène vos plantes et cactus.\r\nCaractéristiques du cache-pot suspendu Sanya :\r\n •  Céramique motifs striés\r\n •  Suspension en corde de sisal\r\n •  Vis et chevilles non fournies.', 15.99, 3, 7, '2021-02-15', 'df0c94de0f03dc154417dee2f9a0c358.jpg', 0),
(22, 'ROTIN TRESSE NATUREL JUTE HOUSE \'DOCTOR WOVEN\'', 'House Doctor est une marque danoise de design résolument scandinave. La maison House Doctor imagine une large gamme de mobilier, textile et accessoires pour une maison moderne et unique. Un style vintage, industriel et design épuré le tout dans une atmosphère intemporelle.', 69, 3, 7, '2021-02-15', '85520efc33e7ee882046dd666277d765.jpg', 0),
(23, 'YINUO  (Size : 37x68cm)', 'Matériau: matériau en pin de haute qualité, poli à la main, beau et durable, sûr et respectueux de l\'environnement.\r\nMulti-purpose: Le support de fleurs multi-fonctionnel n\'est pas seulement un support de fleurs, mais également une étagère, un présentoir, une étagère, un cadre décoratif, etc.', 71.13, 3, 8, '2021-02-15', 'e2b25a37eab31da25874bdf8a1487988.jpg', 0),
(24, 'GRAND POT ROND \'CHARLES\'  62,4L', 'Le grand pot Charles grisé rond en osier a un style rétro et tendance. Il donnera un côté authentique à votre extérieur tout en prenant soin de votre plante !', 69, 3, 8, '2021-02-15', 'ef1e517681094c788e0d969dae4edd35.jpg', 0),
(26, 'PANIER EN CORDE DE COTON 27,9 x 27,9 cm', 'Décoration moderne et élégante: Avec son look et son design minimalistes, notre jardinière d\'intérieur pour plantes en pot est idéale pour ajouter une touche rustique et moderne à n\'importe quelle pièce de votre maison, de votre bureau, de vos lobbys, restaurants, etc.', 18.99, 3, 9, '2021-02-15', 'f96e9b702a165e2b054f231f15b4f628.jpg', 0),
(27, 'BACS A PLANTES  \'BELLY\'', 'Belly paniers multifonctionnelle : notre panier de jute est polyvalent et s\'adapte à vos différents needs. décorative, le stockage créatif, pique-nique, épicerie ou sac de plage ; couvertures de pot pour feuille de violon, figuier ou d\'autres plantes', 21.95, 3, 9, '2021-02-15', 'fcf55eea64f7265f43820590843691b6.jpg', 0),
(28, 'MACRAME POT SUSPENDU \'MKOUO\'', '<p>Le support de plantes moderne d\'inspiration vintage ajoute la touche parfaite à votre pièce et à votre salon. cette beauté embellirait votre maison ou votre jardin avec balcon ou illuminerait un bureau. Aucune plante ou pot de fleurs inclus dans cet article!</p>', 13.99, 3, 9, '2021-02-15', '18849504d61cb95bf7edb8b0369cb7f7.jpg', 0),
(30, 'ARROSOIR JARDIN ALU', 'Très bel arrosoir zinc galvanisé à chaud forme ovale, Arrosoir de jardin 13 l fabriqué en France, destiné aux jardiniers exigeants et sensibles aux beaux outils. Galvanisé zinc à chaud lui permet une parfaite étanchéité, et lui donne une grande longévité, pour un usage normal reconnu pour 25 ans +.', 114, 4, 10, '2021-02-15', 'a2a62c477927f14bac6266d1ef0ec450.jpg', 0),
(31, 'ARROSOIR BEARWOOD BROOK', 'Arroser, c\'est du sérieux\r\nMême équipé d\'un tuyau d\'arrosage ou d\'une installation d\'arrosage automatique, l\'arrosoir reste indispensable pour tout bon jardinier.\r\n\r\nLe secret d\'un bon arrosoir\r\nC\'est l\'équilibre entre le poids, la contenance, l\'ergonomie de la prise en main et le mouvement de bascule nécessaire pour arroser qui fait toute la différence.', 80, 4, 10, '2021-02-15', '1774f26a7bff8cb9a85b1c01626ad514.jpg', 0),
(32, 'ARROSOIR DESIGN \'OR\'', 'Nous en avons terminé avec les gros arrosoirs en plastique vert  de la couleur des bottes en catoutchouc ...( Vous aussi ?).\r\nDésormais, on arrose ses plantes d\'intérieur avec minutie, précision et on reste ultra chic avec cet arrosoir &quot;or&quot; en acier inoxydable à long bec fin.\r\n\r\nOn appréciie les courbes élégantes de cet objet devenu design et chic et on note sa contenance à faire pâlir de jalousir l\'arrosoir de grand-maman.\r\nOn l\'expose dans le salon non ?', 26.95, 4, 10, '2021-02-15', '6cbd6b938e3b6e88eb887d1896915a61.jpeg', 0),
(33, 'HUMIDIFICATEUR PLANTE VERRE', 'pulvérisateur en verre pour humidifier vos plantes d\'intérieur.', 3.95, 4, 11, '2021-02-15', 'e4596fb4c5e5e1f5849ca7c712b3166e.jpg', 0),
(34, 'NORDIC DESIGN 1L', 'Flacon pulvérisateur vide à fleurs,flacon pulvérisateur à brumisation d\'eau,flacon pulvérisateur vide,pulvérisateur à gâchette,arrosoir,pulvérisateur d\'arrosage de jardin,flacon pulvérisateur à cheveux,monsieur plante', 14.58, 4, 11, '2021-02-15', 'de31e7b45bd723e4a5369f103d7cd955.jpg', 0),
(36, 'KIT JARDINAGE 3 OUTILS', 'Set de 3 outils jardinage\r\n\r\nOutils principal pour tout jardinier \r\n\r\nColis de 120 pcs / Sous colis de 12 pcs', 10.9, 4, 12, '2021-02-15', '85df7a43cce33a18d5afbd8529daeddb.jpg', 0),
(37, 'SET OUTILS \'ORTE\'', 'L’excellence made in Italy… La marque «Internoitaliano» a pour vocation de retranscrire l’habitat italien contemporain à travers un projet collectif réunissant designers et artisans transalpins, co-auteurs des objets de la collection. Elle établit à travers toute la péninsule un réseau de workshops où les designers travaillent en étroite collaboration avec des entreprises locales et des artisans spécialisés dans différents domaines (ébénisterie, céramique…).', 168, 4, 12, '2021-02-15', '7ef98c4f86a18c229a9efb43924a001d.jpg', 0),
(38, 'KIT ENFANT 9 OUTILS', 'Initiez les petits aux joies du jardinage avec ces 9 accessoires de jardin de chez Kids in The Garden! Confectionnés en zinc et en bois, leur durabilité est assurée !', 39.99, 4, 12, '2021-02-15', 'fcc8f9dcac43a5801e46e20b1a1c72a0.jpg', 0),
(39, 'AFFICHE ATWTS - PLANT ADDICT', 'Papier mat 200g\r\n\r\nMédium : 29,7x39,7cm\r\n\r\nLarge : 50x70cm\r\n\r\nImprimé en France.\r\nEnvoyé dans une pochette en papier blanc solide,\r\navec fenêtre transparente.', 45, 5, 14, '2021-02-15', 'c37e4d5b4adaca1f42dee516d786ca9a.jpg', 0),
(41, 'AFFICHE ATWTS - CONSERVATOIRE', 'Papier mat 200g\r\n\r\n29,7x39,7cm \r\n\r\nImprimé en France.\r\nEnvoyé dans une pochette en papier blanc solide,\r\navec fenêtre transparente.', 25, 5, 14, '2021-02-15', 'ead966f0a5fc834619f000db903b9096.jpg', 0),
(42, 'TERRARIUM ANNA - TAILLE M', '<p><strong><em>Dimensions :</em></strong></p>\n<p>D : <strong>25cm</strong>. H : <strong>26.5cm</strong>.</p>\n<p><strong><em>Ce que contient le produit :</em></strong> Ficus ginseng \'microscarpa\', fittonia, syngonium &amp; mousse d\'Alsace, sans cache pots.</p>\n<p><strong><em>Conseils d\'entretiens</em></strong></p>\n<ul>\n<li>Mettre un sol meuble pour la base du terra</li>\n<li>Arroser régulièrement (<em>une à deux fois par jour en bruine</em>)</li>\n<li>Rempoter <strong>une fois tous les deux ans</strong></li>\n</ul>', 79, 6, 16, '2021-02-15', '7bc6e759a2aa1ad520ce93fa189bce9b.jpg', 0),
(43, 'TERRARIUM AMÉLIA - TAILLE L', 'Dimensions :  H: 27.5cm D: 27.5cm\r\n\r\nContenu : Ficus ginseng \'microscarpa\', polyscias, chamaedorea elegans, fittonia &amp; mousse d\'Alsace\r\n\r\nRetrouve nos conseils d\'entretien dans lien ci-dessous :\r\nLes plantes qui composent nos terrariums sont garanties 2 mois.', 115, 6, 16, '2021-02-15', '649a497663bfa41d2ec3eaf5c2115803.jpg', 0),
(44, 'TERRARIUM CARL - TAILLE M', 'Dimensions :  D : 19cm H : 30cm\r\n\r\nContenu : Ficus ginseng \'microscarpa\', fittonia &amp; mousse d\'Alsace\r\n\r\nRetrouve nos conseils d\'entretien dans lien ci-dessous :\r\nLes plantes qui composent nos terrariums sont garanties 2 mois.', 59, 6, 16, '2021-02-15', '90fcaa1ba2e9aa34ccdb9cfbafd05923.jpg', 0),
(45, 'TERREAU AGRUMES 4L', 'Un jardin provençal où que vous soyez. Agrumes, Oliviers, Palmiers, Lauriers etc. se déploieront généreusement en pots et en bacs.\r\n\r\nUtilisable en agriculture biologique.', 5.55, 7, 17, '2021-02-15', '8d50e43ddd77af049950556ed46624e5.jpg', 0),
(46, 'TERREAU FLEURS 4L', 'Ce terreau est spécialement conçu pour favoriser la floraison de toutes les plantes fleuries et vivaces cultivées en pots, bacs, et jardinières.\r\n\r\nUtilisable en agriculture biologique.\r\n\r\nFabriqué en France.\r\n\r\nSac d\'origine végétale.', 5.55, 7, 17, '2021-02-15', '93c7c707256a45440cec350f1f845efc.jpg', 0),
(47, 'TERREAU POTS ET JARDINIÈRES 4L', 'Une formule étudiée pour le rempotage des plantes d\'intérieur et d\'extérieur pour qu\'elles soient sans cesse plus vigoureuses.\r\n\r\nUtilisable en agriculture biologique.\r\n\r\nFabriqué en France.\r\n\r\nSac d\'origine végétale.', 5.55, 7, 17, '2021-02-15', '9b7cdd3643dd3705b0833405790da469.jpg', 0),
(48, 'BÂTONNETS ENGRAIS PLANTES VERTES OR BRUN', 'La solution parfaite pour faire pousser toutes sortes de plantes vertes.\r\n\r\nUtilisable en agriculture biologique.\r\n\r\nCertifié Ecocert.\r\n\r\nFabriqué en France.', 6.5, 7, 18, '2021-02-15', '7e1f9f8459ea4e7fce094165870e674f.jpg', 0),
(49, 'FAIM DE GRANDIR UNDERGREEN', 'Les nutriments en granulés Faim de GRANDIR Undergreen favorisent la croissance et la production des petits légumes et herbes aromatiques en pot.', 7, 7, 18, '2021-02-15', 'dbfb1848a4e3c4f0ed9c54f4f16552d0.jpg', 2),
(50, 'NUTRIMENTS CACTÉES ET SUCCULENTES', '<p><strong><em>Un peu de culture</em></strong></p>\n<p><strong>JUNGLE Fever nutriments Cactus et Succulentes Undergreen</strong> favorise le <em>développement de toutes les espèces</em> de cactus et succulentes (ou plantes grasses) : Opuntia, Echeveria, Echinocactus, Crassula,Cereus, Aloe Vera, Sedum, Aenium, Rhipsalis…</p>\n<p><strong><em>Pourquoi acheter ce produit ?</em></strong></p>\n<ul>\n<li>Nourrit abondamment vos plantes vertes</li>\n<li>Rend votre terreau plus fertile</li>\n</ul>', 8, 7, 18, '2021-02-15', 'cd9f5037e588baa47c007886dca71e15.jpg', 0),
(51, 'VEIR MAGAZINE - NUMÉRO 2 – ÉTÉ 2020 : OBSERVER', 'Le thème de ce numéro est « Observer« .\r\n\r\n \r\n\r\nLe dossier spécial, « Au fil de l’eau » vous expliquera comment les plantes utilisent l’eau pour se développer et vous apprendra à arroser de manière efficace et écologique.\r\n\r\nVous trouverez également 22 autres articles qui abordent des sujets liés aux plantes vertes, à la Nature et à l’écologie.', 17, 8, 19, '2021-02-15', 'e83e0fe6d539b1aa920f9bc64c13253c.jpg', 0),
(52, 'VEIR MAGAZINE - NUMÉRO 3 – AUTOMNE 2020 : PARTAGER', '<p><strong><em>Qu\'est-ce qu\'on y retrouve ?</em></strong></p>\n<p>Le thème de ce numéro est <strong><em>« Partager »</em></strong>. Le dossier spécial, <em>« Compost : l’or noir du jardin »</em> vous donnera tous les conseils pratiques pour mettre en œuvre le compostage chez vous, avec ou sans jardin : quel composteur choisir, quels sont les bons gestes, que faire en cas de problème, comment utiliser le compost mûr dans vos plantes (potager ou plantes vertes), etc.</p>\n<p><strong><em>Les engagement de Veir</em></strong></p>\n<ul>\n<li>Des informations sourcées</li>\n<li>Une mise en page originale</li>\n</ul>', 17, 8, 19, '2021-02-15', '104c315bb567511fb19d6c65f14874e0.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id_rights` int(11) NOT NULL AUTO_INCREMENT,
  `name_right` varchar(255) NOT NULL,
  PRIMARY KEY (`id_rights`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rights`
--

INSERT INTO `rights` (`id_rights`, `name_right`) VALUES
(1, 'Utilisateur'),
(42, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `shipping`
--

DROP TABLE IF EXISTS `shipping`;
CREATE TABLE IF NOT EXISTS `shipping` (
  `id_shipping` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `pricing` float NOT NULL,
  PRIMARY KEY (`id_shipping`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id_status`, `name`) VALUES
(1, 'En attente de validation'),
(2, 'En cours de préparation'),
(3, 'En cours de livraison'),
(4, 'Livraison effectuée');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
CREATE TABLE IF NOT EXISTS `stocks` (
  `id_stocks` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `stocks` int(11) NOT NULL,
  PRIMARY KEY (`id_stocks`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id_stocks`, `id_product`, `stocks`) VALUES
(1, 48, 15),
(2, 49, 19),
(3, 1, 20),
(4, 2, 20),
(5, 3, 15),
(6, 4, 20),
(7, 5, 20),
(8, 6, 20),
(9, 7, 20),
(10, 8, 7),
(11, 9, 20),
(12, 10, 20),
(13, 11, 20),
(14, 12, 19),
(15, 13, 20),
(16, 14, 20),
(17, 15, 20),
(18, 16, 20),
(19, 17, 20),
(20, 18, 20),
(21, 19, 20),
(22, 20, 19),
(23, 21, 20),
(24, 22, 20),
(25, 23, 20),
(26, 24, 20),
(27, 25, 7),
(28, 26, 20),
(29, 27, 19),
(30, 28, 20),
(31, 29, 20),
(32, 30, 7),
(33, 31, 16),
(34, 32, 19),
(35, 33, 19),
(36, 34, 20),
(37, 35, 20),
(38, 36, 20),
(39, 37, 20),
(40, 38, 20),
(41, 39, 19),
(42, 40, 20),
(43, 41, 20),
(44, 42, 14),
(45, 43, 20),
(46, 44, 20),
(47, 45, 20),
(48, 46, 20),
(49, 47, 7),
(50, 50, 19),
(51, 51, 20),
(52, 52, 19),
(53, 53, 20),
(54, 55, 20),
(55, 56, 20),
(56, 57, 32),
(57, 58, 2);

-- --------------------------------------------------------

--
-- Structure de la table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `id_subcategory` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_subcategory`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `subcategory`
--

INSERT INTO `subcategory` (`id_subcategory`, `id_category`, `subcategory_name`) VALUES
(1, 1, 'Plantes grasses'),
(2, 1, 'Plantes grimpantes'),
(3, 1, 'Plantes bulbeuses'),
(4, 2, 'Pots de fleurs'),
(5, 2, 'Jardinières'),
(6, 2, 'Pots XXL'),
(7, 3, 'suspendus'),
(8, 3, 'rotin'),
(9, 3, 'corde de coton'),
(10, 4, 'Arrosoirs'),
(11, 4, 'Pulvérisateurs'),
(12, 4, 'Outils'),
(14, 5, 'Affiches'),
(16, 6, 'Terrariums'),
(17, 7, 'Terreau'),
(18, 7, 'angrais'),
(19, 8, 'Librairie');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rights` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `id_rights`, `firstname`, `lastname`, `phone`, `avatar`, `birthdate`, `gender`) VALUES
(1, 'test@test.com', '$2y$10$EsMZWh7ioWLx7d/omKSLv.Y9slO71s2A79opW7S.vIIYZdO5YqONC', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'nicolas.revel@laplateforme.io', '$2y$10$QaNv3i6SvF.MPMup5204V.Dqghx890dd1mofEtxI5hO/.M5FZWsWO', 42, 'Nicolas', 'Revel', '06 38 40 71 94', '783ef739cd32665d645c4fcfe12980d2.jpg', '1996-02-23', 'Masculin'),
(3, 'emma.laprevote@laplateforme.io', '$2y$10$6BqQRwn7JbYV7G4urApEXOlFgqK6DodGRILC9sl0Wvnb6ZsGKu9u6', 42, 'Emma', NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
