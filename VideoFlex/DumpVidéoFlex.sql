--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 9.6.15

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: acteur_id_act_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.acteur_id_act_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acteur_id_act_seq OWNER TO bsoutars;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acteur; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.acteur (
    id_act integer DEFAULT nextval('public.acteur_id_act_seq'::regclass) NOT NULL,
    nom character varying(25) NOT NULL,
    prenom character varying(25) NOT NULL,
    CONSTRAINT acteur_id_act_check CHECK ((id_act >= 0))
);


ALTER TABLE public.acteur OWNER TO bsoutars;

--
-- Name: caracteriser; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.caracteriser (
    id_profil integer NOT NULL,
    id_vid integer NOT NULL,
    id_label integer NOT NULL,
    CONSTRAINT caracteriser_id_label_check CHECK ((id_label >= 0)),
    CONSTRAINT caracteriser_id_profil_check CHECK ((id_profil >= 0)),
    CONSTRAINT caracteriser_id_vid_check CHECK ((id_vid >= 0))
);


ALTER TABLE public.caracteriser OWNER TO bsoutars;

--
-- Name: client_num_cli_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.client_num_cli_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.client_num_cli_seq OWNER TO bsoutars;

--
-- Name: client; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.client (
    num_cli integer DEFAULT nextval('public.client_num_cli_seq'::regclass) NOT NULL,
    nom character varying(25) NOT NULL,
    prenom character varying(25) NOT NULL,
    adresse character varying(100) NOT NULL,
    courriel character varying(75) NOT NULL,
    date_deb_abo date,
    date_fin_abo date,
    type_abo character(7),
    mdp text NOT NULL,
    CONSTRAINT client_num_cli_check CHECK (((num_cli)::double precision >= (0)::double precision)),
    CONSTRAINT client_type_abo_check CHECK (((type_abo = 'premium'::bpchar) OR (type_abo = 'normaux'::bpchar)))
);


ALTER TABLE public.client OWNER TO bsoutars;

--
-- Name: historique_id_hist_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.historique_id_hist_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.historique_id_hist_seq OWNER TO bsoutars;

--
-- Name: historique; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.historique (
    id_hist integer DEFAULT nextval('public.historique_id_hist_seq'::regclass) NOT NULL,
    minuteur time without time zone NOT NULL,
    id_profil integer NOT NULL,
    id_vid integer NOT NULL,
    CONSTRAINT historique_id_hist_check CHECK ((id_hist >= 0)),
    CONSTRAINT historique_id_profil_check CHECK ((id_profil >= 0)),
    CONSTRAINT historique_id_vid_check CHECK ((id_vid >= 0))
);


ALTER TABLE public.historique OWNER TO bsoutars;

--
-- Name: jouer; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.jouer (
    id_vid integer NOT NULL,
    id_act integer NOT NULL,
    id_pers integer NOT NULL,
    CONSTRAINT jouer_id_act_check CHECK ((id_act >= 0)),
    CONSTRAINT jouer_id_pers_check CHECK ((id_pers >= 0)),
    CONSTRAINT jouer_id_vid_check CHECK ((id_vid >= 0))
);


ALTER TABLE public.jouer OWNER TO bsoutars;

--
-- Name: label_id_label_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.label_id_label_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.label_id_label_seq OWNER TO bsoutars;

--
-- Name: label; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.label (
    id_label integer DEFAULT nextval('public.label_id_label_seq'::regclass) NOT NULL,
    nom character(25) NOT NULL,
    CONSTRAINT label_id_label_check CHECK ((id_label >= 0))
);


ALTER TABLE public.label OWNER TO bsoutars;

--
-- Name: noter; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.noter (
    id_profil integer NOT NULL,
    id_vid integer NOT NULL,
    note smallint NOT NULL,
    CONSTRAINT noter_id_profil_check CHECK ((id_profil >= 0)),
    CONSTRAINT noter_id_vid_check CHECK ((id_vid >= 0)),
    CONSTRAINT noter_note_check CHECK (((note >= 0) AND (note <= 10)))
);


ALTER TABLE public.noter OWNER TO bsoutars;

--
-- Name: personne_id_pers_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.personne_id_pers_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personne_id_pers_seq OWNER TO bsoutars;

--
-- Name: personnage; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.personnage (
    id_pers integer DEFAULT nextval('public.personne_id_pers_seq'::regclass) NOT NULL,
    nom character varying(25) NOT NULL,
    CONSTRAINT personnage_id_pers_check CHECK ((id_pers >= 0))
);


ALTER TABLE public.personnage OWNER TO bsoutars;

--
-- Name: profil_id_profil_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.profil_id_profil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profil_id_profil_seq OWNER TO bsoutars;

--
-- Name: profil; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.profil (
    id_profil integer DEFAULT nextval('public.profil_id_profil_seq'::regclass) NOT NULL,
    pseudo character varying(10) NOT NULL,
    num_cli integer NOT NULL,
    CONSTRAINT profil_id_profil_check CHECK ((id_profil >= 0)),
    CONSTRAINT profil_num_cli_check CHECK ((num_cli >= 0))
);


ALTER TABLE public.profil OWNER TO bsoutars;

--
-- Name: realisateur_id_real_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.realisateur_id_real_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.realisateur_id_real_seq OWNER TO bsoutars;

--
-- Name: realisateur; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.realisateur (
    id_real integer DEFAULT nextval('public.realisateur_id_real_seq'::regclass) NOT NULL,
    nom character varying(25) NOT NULL,
    prenom character varying(25) NOT NULL,
    CONSTRAINT realisateur_id_real_check CHECK ((id_real >= 0))
);


ALTER TABLE public.realisateur OWNER TO bsoutars;

--
-- Name: saison_id_saison_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.saison_id_saison_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.saison_id_saison_seq OWNER TO bsoutars;

--
-- Name: saison; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.saison (
    id_saison integer DEFAULT nextval('public.saison_id_saison_seq'::regclass) NOT NULL,
    id_serie integer,
    num_saison smallint NOT NULL,
    CONSTRAINT saison_id_saison_check CHECK ((id_saison >= 0)),
    CONSTRAINT saison_id_serie_check CHECK ((id_serie >= 0)),
    CONSTRAINT saison_num_saison_check CHECK ((num_saison >= 0))
);


ALTER TABLE public.saison OWNER TO bsoutars;

--
-- Name: serie_id_serie_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.serie_id_serie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.serie_id_serie_seq OWNER TO bsoutars;

--
-- Name: serie; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.serie (
    id_serie integer DEFAULT nextval('public.serie_id_serie_seq'::regclass) NOT NULL,
    titre_serie character varying(100) NOT NULL,
    CONSTRAINT serie_id_serie_check CHECK ((id_serie >= 0))
);


ALTER TABLE public.serie OWNER TO bsoutars;

--
-- Name: video_id_vid_seq; Type: SEQUENCE; Schema: public; Owner: bsoutars
--

CREATE SEQUENCE public.video_id_vid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.video_id_vid_seq OWNER TO bsoutars;

--
-- Name: video; Type: TABLE; Schema: public; Owner: bsoutars
--

CREATE TABLE public.video (
    id_vid integer DEFAULT nextval('public.video_id_vid_seq'::regclass) NOT NULL,
    titre character varying(255) NOT NULL,
    duree time without time zone NOT NULL,
    anne_prod date NOT NULL,
    label character varying(25),
    note smallint,
    id_real integer NOT NULL,
    num_ep integer,
    id_saison integer,
    resume text,
    CONSTRAINT video_id_real_check CHECK ((id_real >= 0)),
    CONSTRAINT video_id_saison_check CHECK ((id_saison >= 0)),
    CONSTRAINT video_id_vid_check CHECK ((id_vid >= 0)),
    CONSTRAINT video_note_check CHECK (((note >= 0) AND (note <= 10))),
    CONSTRAINT video_num_ep_check CHECK ((num_ep > 0))
);


ALTER TABLE public.video OWNER TO bsoutars;

--
-- Data for Name: acteur; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.acteur VALUES (1, 'Phoenix', 'Joaquin');
INSERT INTO public.acteur VALUES (2, 'Dumond', 'Sophie');
INSERT INTO public.acteur VALUES (3, 'Reynolds', 'Ryan');
INSERT INTO public.acteur VALUES (4, 'Smith', 'Justice');
INSERT INTO public.acteur VALUES (5, 'Schiling', 'Taylor');
INSERT INTO public.acteur VALUES (6, 'Prepon', 'Laura');
INSERT INTO public.acteur VALUES (7, 'Biggs', 'Jason');
INSERT INTO public.acteur VALUES (8, 'Worthington', 'Sam');
INSERT INTO public.acteur VALUES (9, 'DiCaprio', 'Leonardo');
INSERT INTO public.acteur VALUES (10, 'Winslet', 'Kate');


--
-- Name: acteur_id_act_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.acteur_id_act_seq', 1, false);


--
-- Data for Name: caracteriser; Type: TABLE DATA; Schema: public; Owner: bsoutars
--



--
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: bsoutars
--



--
-- Name: client_num_cli_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.client_num_cli_seq', 56, true);


--
-- Data for Name: historique; Type: TABLE DATA; Schema: public; Owner: bsoutars
--



--
-- Name: historique_id_hist_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.historique_id_hist_seq', 61, true);


--
-- Data for Name: jouer; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.jouer VALUES (1, 1, 1);
INSERT INTO public.jouer VALUES (1, 2, 2);
INSERT INTO public.jouer VALUES (2, 3, 3);
INSERT INTO public.jouer VALUES (2, 4, 4);
INSERT INTO public.jouer VALUES (3, 5, 5);
INSERT INTO public.jouer VALUES (3, 6, 6);
INSERT INTO public.jouer VALUES (4, 5, 5);
INSERT INTO public.jouer VALUES (4, 6, 6);
INSERT INTO public.jouer VALUES (7, 1, 7);


--
-- Data for Name: label; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.label VALUES (1, 'Thriller                 ');
INSERT INTO public.label VALUES (2, 'Fantastique              ');
INSERT INTO public.label VALUES (3, 'Comédie Dramatique       ');
INSERT INTO public.label VALUES (4, 'Sci-Fi                   ');
INSERT INTO public.label VALUES (5, 'Humoristique             ');
INSERT INTO public.label VALUES (6, 'Humour noir              ');
INSERT INTO public.label VALUES (7, 'horreur                  ');
INSERT INTO public.label VALUES (8, 'marrant                  ');
INSERT INTO public.label VALUES (9, 'qsfs                     ');
INSERT INTO public.label VALUES (10, 'salut                    ');
INSERT INTO public.label VALUES (11, 'Comédie                  ');
INSERT INTO public.label VALUES (12, 'Comedie Dramatique       ');
INSERT INTO public.label VALUES (13, 'triste                   ');
INSERT INTO public.label VALUES (14, 'dyhd                     ');
INSERT INTO public.label VALUES (15, 'Prison                   ');
INSERT INTO public.label VALUES (16, 'Triste                   ');
INSERT INTO public.label VALUES (17, 'Western                  ');


--
-- Name: label_id_label_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.label_id_label_seq', 17, true);


--
-- Data for Name: noter; Type: TABLE DATA; Schema: public; Owner: bsoutars
--



--
-- Data for Name: personnage; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.personnage VALUES (1, 'Joker');
INSERT INTO public.personnage VALUES (2, 'Zazie Beetz');
INSERT INTO public.personnage VALUES (3, 'Harry Goodman');
INSERT INTO public.personnage VALUES (4, 'Tim Goodman');
INSERT INTO public.personnage VALUES (5, 'Piper Chapman');
INSERT INTO public.personnage VALUES (6, 'Alex Vause');
INSERT INTO public.personnage VALUES (7, 'Charlie Sisters');


--
-- Name: personne_id_pers_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.personne_id_pers_seq', 1, false);


--
-- Data for Name: profil; Type: TABLE DATA; Schema: public; Owner: bsoutars
--



--
-- Name: profil_id_profil_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.profil_id_profil_seq', 128, true);


--
-- Data for Name: realisateur; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.realisateur VALUES (1, 'Philipps', 'Todd');
INSERT INTO public.realisateur VALUES (2, 'Letterman', 'Rob');
INSERT INTO public.realisateur VALUES (3, 'Kohan', 'Jenji');
INSERT INTO public.realisateur VALUES (4, 'Harmon', 'Dan');
INSERT INTO public.realisateur VALUES (5, 'Audiard', 'Jacques');
INSERT INTO public.realisateur VALUES (6, 'Abrams', 'J.J');
INSERT INTO public.realisateur VALUES (7, 'Lee', 'Jennifer');
INSERT INTO public.realisateur VALUES (8, 'Ladj', 'Ly');
INSERT INTO public.realisateur VALUES (10, 'Cazes', 'Éric');
INSERT INTO public.realisateur VALUES (11, 'Polanski', 'Roman');
INSERT INTO public.realisateur VALUES (12, 'Séguéla', 'Tristan ');
INSERT INTO public.realisateur VALUES (13, 'Rice', 'John');
INSERT INTO public.realisateur VALUES (14, 'Polcino', 'Dominic');
INSERT INTO public.realisateur VALUES (15, 'Favreau', 'Jon');
INSERT INTO public.realisateur VALUES (16, 'Schmidt Hissrich', 'Lauren');
INSERT INTO public.realisateur VALUES (17, 'Johnson', 'Mark ');


--
-- Name: realisateur_id_real_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.realisateur_id_real_seq', 17, true);


--
-- Data for Name: saison; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.saison VALUES (1, 1, 1);
INSERT INTO public.saison VALUES (2, 1, 2);
INSERT INTO public.saison VALUES (3, 2, 1);
INSERT INTO public.saison VALUES (4, 2, 2);
INSERT INTO public.saison VALUES (5, 3, 1);
INSERT INTO public.saison VALUES (6, 4, 1);
INSERT INTO public.saison VALUES (7, 5, 1);
INSERT INTO public.saison VALUES (8, 5, 2);


--
-- Name: saison_id_saison_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.saison_id_saison_seq', 8, true);


--
-- Data for Name: serie; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.serie VALUES (1, 'Orange is the new Black');
INSERT INTO public.serie VALUES (2, 'Rick et Morty');
INSERT INTO public.serie VALUES (3, 'The Mandalorian');
INSERT INTO public.serie VALUES (4, 'The Witcher');
INSERT INTO public.serie VALUES (5, 'Breaking Bad');


--
-- Name: serie_id_serie_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.serie_id_serie_seq', 5, true);


--
-- Data for Name: video; Type: TABLE DATA; Schema: public; Owner: bsoutars
--

INSERT INTO public.video VALUES (1, 'Joker', '02:02:00', '2019-10-09', 'Thriller', NULL, 1, NULL, NULL, NULL);
INSERT INTO public.video VALUES (2, 'Détective Pikachu', '01:45:00', '2019-05-08', 'Fantastique', NULL, 2, NULL, NULL, NULL);
INSERT INTO public.video VALUES (3, 'Je nétais pas prête', '00:52:00', '2013-07-11', 'Comedie Dramatique', NULL, 3, 1, 1, NULL);
INSERT INTO public.video VALUES (4, 'L`oiseau assoiffé', '00:57:00', '2014-06-06', 'Comedie Dramatique', NULL, 3, 1, 2, NULL);
INSERT INTO public.video VALUES (5, 'De la graine de héros', '00:22:00', '2013-12-02', 'Sci-fi', NULL, 4, 1, 3, NULL);
INSERT INTO public.video VALUES (6, 'Effet Rick-ochet', '00:22:00', '2015-07-26', 'Sci-fi', NULL, 4, 1, 4, NULL);
INSERT INTO public.video VALUES (7, 'Les frères Sisters', '02:01:00', '2018-09-19', 'Western', 7, 5, NULL, NULL, NULL);
INSERT INTO public.video VALUES (8, 'STAR WARS L ASCENSION DE SKYWALKER', '02:22:00', '2019-12-18', NULL, NULL, 6, NULL, NULL, 'La conclusion de la saga Skywalker. De nouvelles légendes vont naître dans cette bataille épique pour la liberté.');
INSERT INTO public.video VALUES (9, 'LA REINE DES NEIGES 2', '01:44:00', '2019-11-20', NULL, NULL, 7, NULL, NULL, 'Pourquoi Elsa est-elle née avec des pouvoirs magiques ? La jeune fille rêve de l’apprendre, mais la réponse met son royaume en danger. Avec l’aide d’Anna, Kristoff, Olaf et Sven, Elsa entreprend un voyage aussi périlleux qu’extraordinaire. Dans La Reine des neiges, Elsa craignait que ses pouvoirs ne menacent le monde. Dans La Reine des neiges 2, elle espère qu’ils seront assez puissants pour le sauver…');
INSERT INTO public.video VALUES (10, 'LES MISÉRABLES', '01:42:00', '2019-11-20', NULL, NULL, 8, NULL, NULL, 'Stéphane, tout juste arrivé de Cherbourg, intègre la Brigade Anti-Criminalité de Montfermeil, dans le 93. Il va faire la rencontre de ses nouveaux coéquipiers, Chris et Gwada, deux "Bacqueux" d’expérience. Il découvre rapidement les tensions entre les différents groupes du quartier. Alors qu’ils se trouvent débordés lors d’une interpellation, un drone filme leurs moindres faits et gestes...');
INSERT INTO public.video VALUES (11, 'VIC LE VIKING', '01:21:00', '2019-12-18', NULL, NULL, 10, NULL, NULL, 'Vic est un jeune Viking pas comme les autres : pas très costaud mais très malin. Quand son père, Halvar, le chef du village, dérobe à son ennemi juré une épée magique qui transforme tout en or, l’appât du gain sème la pagaille chez les Vikings ! Vic va alors devoir embarquer pour un périlleux voyage vers une île mythique du grand Nord pour briser le sortilège de l’épée…');
INSERT INTO public.video VALUES (12, 'J''ACCUSE', '02:12:00', '2019-11-13', NULL, NULL, 11, NULL, NULL, 'Pendant les 12 années qu elle dura, l’Affaire Dreyfus déchira la France, provoquant un véritable séisme dans le monde entier.
Dans cet immense scandale, le plus grand sans doute de la fin du XIXème siècle, se mêlent erreur judiciaire, déni de justice et antisémitisme. L’affaire est racontée du point de vue du Colonel Picquart qui, une fois nommé à la tête du contre-espionnage, va découvrir que les preuves contre le Capitaine Alfred Dreyfus avaient été fabriquées.
A partir de cet instant et au péril de sa carrière puis de sa vie, il n aura de cesse d identifier les vrais coupables et de réhabiliter Alfred Dreyfus.');
INSERT INTO public.video VALUES (13, 'DOCTEUR ?', '01:28:00', '2019-12-11', NULL, NULL, 12, NULL, NULL, 'C''est le soir de Noël. Les parisiens les plus chanceux se préparent à déballer leurs cadeaux en famille. D''autres regardent la télévision seuls chez eux. D''autres encore, comme Serge, travaillent. Serge est le seul SOS-Médecin de garde ce soir-là. Ses collègues se sont tous défilés. De toute façon il n''a plus son mot à dire car il a pris trop de libertés avec l''exercice de la médecine, et la radiation lui pend au nez. Les visites s''enchaînent et Serge essaye de suivre le rythme, de mauvaise grâce, quand tombe l''adresse de sa prochaine consultation. C''est celle de Rose, une relation de famille, qui l''appelle à l''aide. Il arrive sur les lieux en même temps qu''un livreur Uber Eats, Malek, lui aussi de service ce soir-là...');
INSERT INTO public.video VALUES (14, 'I, Croquette', '00:22:21', '2013-12-02', NULL, NULL, 13, 2, 3, 'Pendant que Rick et Morty s''infiltrent dans le rêve du professeur de maths du jeune homme, la famille Smith voit évoluer l''intelligence de son chien, à l''aide d''un dispositif mis en place par Rick permettant au canidé de penser.');
INSERT INTO public.video VALUES (15, 'Anatomy Park', '00:22:28', '2013-12-09', NULL, NULL, 13, 3, 3, 'Jerry reçoit sa famille pour Noël, tandis ce que Rick engage Morty pour entretenir le parc d''attraction qu''il a construit dans le corps d''un sans-abri : Anatomy Park. ');
INSERT INTO public.video VALUES (16, 'M. Night Shaym-Aliens!', '00:21:02', '2014-01-13', NULL, NULL, 13, 4, 3, 'Rick découvre qu''il est enfermé dans une simulation avec Morty, par des extra-terrestres qui souhaitent récupérer la recette de l''antimatière, que Rick est le seul à connaître. Jerry est, par erreur, le seul autre être vivant dans cette simulation. ');
INSERT INTO public.video VALUES (17, 'La Boîte à larbins
Meeseeks and Destroy', '00:19:21', '2014-01-20', NULL, NULL, 13, 5, 3, 'Pour satisfaire les volontés de sa famille, Rick leur offre une boîte à Meeseeks, faisant apparaître des personnages qui disparaissent une fois qu''ils ont fini d''aider la personne qui les a fait naître à faire une tâche. Pendant ce temps Rick accorde à Morty une aventure qu''il peut choisir. ');
INSERT INTO public.video VALUES (18, 'Prout, l''extra-terrestre', '00:22:21', '2015-03-07', NULL, NULL, 14, 2, 4, 'Morty et Summer brisent le temps par erreur. Jerry et Beth heurtent un cerf, qui va mettre l''égo de Beth à dure épreuve. ');
INSERT INTO public.video VALUES (19, 'Assimilation auto-érotique', '00:22:17', '2015-03-17', NULL, NULL, 14, 3, 4, 'Rick fait des retrouvailles avec Unity, son ancienne petite amie, une entité pouvant prendre le contrôle de tous les habitants d''une planète. Beth et Jerry découvrent un secret caché dans leur garage. ');
INSERT INTO public.video VALUES (20, 'Total Rickall', '00:22:21', '2015-03-28', NULL, NULL, 14, 4, 4, 'La maison des Smith est envahie par des parasites qui prennent la forme de personnages que la famille pensent avoir connus toute leur vie, mettant leur confiance entre eux à rude épreuve. ');
INSERT INTO public.video VALUES (21, 'Chapitre 1', '00:45:14', '2019-11-12', NULL, NULL, 15, 3, 3, 'L''univers de Star Wars se déroule dans une galaxie qui est le théâtre d''affrontements entre les Chevaliers Jedi et les Seigneurs noirs des Sith, personnes sensibles à la Force, un champ énergétique mystérieux leur procurant des pouvoirs psychiques. Les Jedi maîtrisent le côté lumineux de la Force, pouvoir bénéfique et défensif, pour maintenir la paix dans la galaxie');
INSERT INTO public.video VALUES (22, 'Chapitre 2 : L''Enfant', '00:45:13', '2019-11-15', NULL, NULL, 15, 3, 3, 'L''univers de Star Wars se déroule dans une galaxie qui est le théâtre d''affrontements entre les Chevaliers Jedi et les Seigneurs noirs des Sith, personnes sensibles à la Force, un champ énergétique mystérieux leur procurant des pouvoirs psychiques. Les Jedi maîtrisent le côté lumineux de la Force, pouvoir bénéfique et défensif, pour maintenir la paix dans la galaxie');
INSERT INTO public.video VALUES (23, 'Chapitre 3 : Le Péché', '00:47:15', '2019-11-22', NULL, NULL, 15, 3, 3, 'L''univers de Star Wars se déroule dans une galaxie qui est le théâtre d''affrontements entre les Chevaliers Jedi et les Seigneurs noirs des Sith, personnes sensibles à la Force, un champ énergétique mystérieux leur procurant des pouvoirs psychiques. Les Jedi maîtrisent le côté lumineux de la Force, pouvoir bénéfique et défensif, pour maintenir la paix dans la galaxie. Les Sith utilisent le côté obscur, pouvoir nuisible et destructeur, pour leurs usages personnels et pour dominer la galaxie.');
INSERT INTO public.video VALUES (24, 'The End''s Beginning', '00:45:13', '2019-12-18', NULL, NULL, 16, 1, 6, '');
INSERT INTO public.video VALUES (25, 'Chute libre', '00:45:13', '2013-02-20', NULL, NULL, 17, 1, 7, 'Walter « Walt » White est un professeur de chimie dans un lycée du Nouveau-Mexique et un père de famille de 50 ans. Sa femme Skyler est enceinte et son fils Walter Jr., est handicapé. Son quotidien déjà morose devient carrément noir lorsqu''il apprend qu''il est atteint d''un incurable cancer des poumons. Les médecins ne lui donnent pas plus de deux ans à vivre.');
INSERT INTO public.video VALUES (26, 'Traqués', '00:45:13', '2014-01-13', NULL, NULL, 17, 1, 8, 'Walter commence à se faire un nom dans le milieu de la drogue, sous le pseudonyme d''Heisenberg. La nouvelle double vie de Walter manque à maintes reprises d''être découverte par sa famille, à qui il a finalement avoué son cancer. Skyler, très inquiète, décide de reprendre son ancien travail de comptable, alors qu''elle est à huit mois de grossesse. Mais ses soupçons envers son mari sont de plus en plus insistants. Walt et Jesse décident de monter leur propre affaire de trafic de drogue.');


--
-- Name: video_id_vid_seq; Type: SEQUENCE SET; Schema: public; Owner: bsoutars
--

SELECT pg_catalog.setval('public.video_id_vid_seq', 26, true);


--
-- Name: acteur acteur_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.acteur
    ADD CONSTRAINT acteur_pkey PRIMARY KEY (id_act);


--
-- Name: caracteriser caracteriser_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.caracteriser
    ADD CONSTRAINT caracteriser_pkey PRIMARY KEY (id_profil, id_vid, id_label);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (num_cli);


--
-- Name: historique historique_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.historique
    ADD CONSTRAINT historique_pkey PRIMARY KEY (id_hist);


--
-- Name: jouer jouer_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.jouer
    ADD CONSTRAINT jouer_pkey PRIMARY KEY (id_vid, id_act, id_pers);


--
-- Name: label label_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.label
    ADD CONSTRAINT label_pkey PRIMARY KEY (id_label);


--
-- Name: noter noter_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.noter
    ADD CONSTRAINT noter_pkey PRIMARY KEY (id_profil, id_vid);


--
-- Name: personnage personnage_nom_key; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.personnage
    ADD CONSTRAINT personnage_nom_key UNIQUE (nom);


--
-- Name: personnage personnage_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.personnage
    ADD CONSTRAINT personnage_pkey PRIMARY KEY (id_pers);


--
-- Name: profil profil_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.profil
    ADD CONSTRAINT profil_pkey PRIMARY KEY (id_profil);


--
-- Name: realisateur realisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.realisateur
    ADD CONSTRAINT realisateur_pkey PRIMARY KEY (id_real);


--
-- Name: saison saison_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.saison
    ADD CONSTRAINT saison_pkey PRIMARY KEY (id_saison);


--
-- Name: serie serie_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.serie
    ADD CONSTRAINT serie_pkey PRIMARY KEY (id_serie);


--
-- Name: label unicite_nom; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.label
    ADD CONSTRAINT unicite_nom UNIQUE (nom);


--
-- Name: video video_pkey; Type: CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.video
    ADD CONSTRAINT video_pkey PRIMARY KEY (id_vid);


--
-- Name: caracteriser caracteriser_id_label_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.caracteriser
    ADD CONSTRAINT caracteriser_id_label_fkey FOREIGN KEY (id_label) REFERENCES public.label(id_label) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: caracteriser caracteriser_id_profil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.caracteriser
    ADD CONSTRAINT caracteriser_id_profil_fkey FOREIGN KEY (id_profil) REFERENCES public.profil(id_profil) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: caracteriser caracteriser_id_vid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.caracteriser
    ADD CONSTRAINT caracteriser_id_vid_fkey FOREIGN KEY (id_vid) REFERENCES public.video(id_vid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: historique historique_id_profil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.historique
    ADD CONSTRAINT historique_id_profil_fkey FOREIGN KEY (id_profil) REFERENCES public.profil(id_profil) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: historique historique_id_vid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.historique
    ADD CONSTRAINT historique_id_vid_fkey FOREIGN KEY (id_vid) REFERENCES public.video(id_vid);


--
-- Name: jouer jouer_id_act_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.jouer
    ADD CONSTRAINT jouer_id_act_fkey FOREIGN KEY (id_act) REFERENCES public.acteur(id_act);


--
-- Name: jouer jouer_id_pers_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.jouer
    ADD CONSTRAINT jouer_id_pers_fkey FOREIGN KEY (id_pers) REFERENCES public.personnage(id_pers);


--
-- Name: jouer jouer_id_vid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.jouer
    ADD CONSTRAINT jouer_id_vid_fkey FOREIGN KEY (id_vid) REFERENCES public.video(id_vid);


--
-- Name: noter noter_id_profil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.noter
    ADD CONSTRAINT noter_id_profil_fkey FOREIGN KEY (id_profil) REFERENCES public.profil(id_profil) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: noter noter_id_vid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.noter
    ADD CONSTRAINT noter_id_vid_fkey FOREIGN KEY (id_vid) REFERENCES public.video(id_vid);


--
-- Name: profil profil_num_cli_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.profil
    ADD CONSTRAINT profil_num_cli_fkey FOREIGN KEY (num_cli) REFERENCES public.client(num_cli);


--
-- Name: saison saison_id_serie_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.saison
    ADD CONSTRAINT saison_id_serie_fkey FOREIGN KEY (id_serie) REFERENCES public.serie(id_serie);


--
-- Name: video video_id_real_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.video
    ADD CONSTRAINT video_id_real_fkey FOREIGN KEY (id_real) REFERENCES public.realisateur(id_real);


--
-- Name: video video_id_saison_fkey; Type: FK CONSTRAINT; Schema: public; Owner: bsoutars
--

ALTER TABLE ONLY public.video
    ADD CONSTRAINT video_id_saison_fkey FOREIGN KEY (id_saison) REFERENCES public.saison(id_saison);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

