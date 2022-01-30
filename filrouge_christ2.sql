--
-- PostgreSQL database dump
--

-- Dumped from database version 10.16 (Ubuntu 10.16-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.16 (Ubuntu 10.16-0ubuntu0.18.04.1)

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
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: associer_avance_detail; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.associer_avance_detail (
    iddetailfrais integer NOT NULL,
    iddmdeavce bigint NOT NULL
);


ALTER TABLE public.associer_avance_detail OWNER TO stag;

--
-- Name: associer_rbmt_detail; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.associer_rbmt_detail (
    iddmderbsmt bigint NOT NULL,
    iddetailfrais integer NOT NULL
);


ALTER TABLE public.associer_rbmt_detail OWNER TO stag;

--
-- Name: bareme_kilometrique; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.bareme_kilometrique (
    puissanceadmin integer NOT NULL,
    tarif real NOT NULL
);


ALTER TABLE public.bareme_kilometrique OWNER TO stag;

--
-- Name: client; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.client (
    numsiret integer NOT NULL,
    codetypecli character varying(5) NOT NULL,
    nomclient character varying(100) NOT NULL
);


ALTER TABLE public.client OWNER TO stag;

--
-- Name: demande_avance; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.demande_avance (
    iddmdeavce integer NOT NULL,
    idmission bigint NOT NULL,
    montantdemande money NOT NULL,
    nbrenuitee integer,
    justificatifnuitee character varying(255),
    datedmande timestamp without time zone,
    montanttotalavance numeric(10,2)
);


ALTER TABLE public.demande_avance OWNER TO stag;

--
-- Name: demande_avance_iddmdeavce_seq; Type: SEQUENCE; Schema: public; Owner: stag
--

CREATE SEQUENCE public.demande_avance_iddmdeavce_seq
    AS integer
    START WITH 5
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.demande_avance_iddmdeavce_seq OWNER TO stag;

--
-- Name: demande_avance_iddmdeavce_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: stag
--

ALTER SEQUENCE public.demande_avance_iddmdeavce_seq OWNED BY public.demande_avance.iddmdeavce;


--
-- Name: demande_remboursement; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.demande_remboursement (
    iddmderbsmt integer NOT NULL,
    idmission bigint NOT NULL,
    datedmde timestamp without time zone,
    nbrerepas integer,
    nbrenuitee integer,
    kmsparcourus integer,
    justificatifnuitee character varying(255),
    immatriculation character varying(9)
);


ALTER TABLE public.demande_remboursement OWNER TO stag;

--
-- Name: demande_remboursement_iddmderbsmt_seq; Type: SEQUENCE; Schema: public; Owner: stag
--

CREATE SEQUENCE public.demande_remboursement_iddmderbsmt_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.demande_remboursement_iddmderbsmt_seq OWNER TO stag;

--
-- Name: demande_remboursement_iddmderbsmt_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: stag
--

ALTER SEQUENCE public.demande_remboursement_iddmderbsmt_seq OWNED BY public.demande_remboursement.iddmderbsmt;


--
-- Name: detail_frais_reel; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.detail_frais_reel (
    iddetailfrais integer NOT NULL,
    codetypo character varying(4) NOT NULL,
    naturefrais character varying(100) NOT NULL,
    montanttotalfrais numeric(10,2)
);


ALTER TABLE public.detail_frais_reel OWNER TO stag;

--
-- Name: detail_frais_reel_iddetailfrais_seq; Type: SEQUENCE; Schema: public; Owner: stag
--

CREATE SEQUENCE public.detail_frais_reel_iddetailfrais_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detail_frais_reel_iddetailfrais_seq OWNER TO stag;

--
-- Name: detail_frais_reel_iddetailfrais_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: stag
--

ALTER SEQUENCE public.detail_frais_reel_iddetailfrais_seq OWNED BY public.detail_frais_reel.iddetailfrais;


--
-- Name: employe; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.employe (
    idemp character varying(128) NOT NULL,
    idservice character varying(10) NOT NULL,
    codeprofil character varying(10) NOT NULL,
    nom character varying(100) NOT NULL,
    prenom character varying(100) NOT NULL,
    courriel character varying(255) NOT NULL,
    motdepasse character varying(50) NOT NULL,
    civilite character varying(5) NOT NULL
);


ALTER TABLE public.employe OWNER TO stag;

--
-- Name: etat_avcmt_avance; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.etat_avcmt_avance (
    iddmdeavce bigint NOT NULL,
    codeetat character varying(5) NOT NULL,
    datevaletat character(32)
);


ALTER TABLE public.etat_avcmt_avance OWNER TO stag;

--
-- Name: etat_avcmt_rbrsmt; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.etat_avcmt_rbrsmt (
    codeetat character varying(5) NOT NULL,
    iddmderbsmt bigint NOT NULL,
    datevaletat timestamp without time zone
);


ALTER TABLE public.etat_avcmt_rbrsmt OWNER TO stag;

--
-- Name: etrechef; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.etrechef (
    idemp character varying(128) NOT NULL,
    idemp_1 character varying(128) NOT NULL,
    idemp_chef_de_service character varying(128)
);


ALTER TABLE public.etrechef OWNER TO stag;

--
-- Name: index_etat_avancement; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.index_etat_avancement (
    codeetat character varying(5) NOT NULL,
    libelleetat character varying(100) NOT NULL
);


ALTER TABLE public.index_etat_avancement OWNER TO stag;

--
-- Name: justificatif; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.justificatif (
    idjustificatif integer NOT NULL,
    iddetailfrais integer NOT NULL,
    libellejustificatif character varying(100) NOT NULL,
    nomfichier character varying(255)
);


ALTER TABLE public.justificatif OWNER TO stag;

--
-- Name: justificatif_idjusticatif_seq; Type: SEQUENCE; Schema: public; Owner: stag
--

CREATE SEQUENCE public.justificatif_idjusticatif_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.justificatif_idjusticatif_seq OWNER TO stag;

--
-- Name: justificatif_idjusticatif_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: stag
--

ALTER SEQUENCE public.justificatif_idjusticatif_seq OWNED BY public.justificatif.idjustificatif;


--
-- Name: mission; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.mission (
    idmission integer NOT NULL,
    idemp character varying(128) NOT NULL,
    codezone character varying(2) NOT NULL,
    numsiret integer,
    codeactiv character varying(3) NOT NULL,
    dateheuredebut timestamp without time zone NOT NULL,
    dateheurefin timestamp without time zone NOT NULL,
    numordremission bigint NOT NULL,
    lienordremission character varying(255) NOT NULL,
    dateheuredepart timestamp without time zone,
    dateheureretour timestamp without time zone,
    codepostal integer,
    adresse character varying(128),
    ville character varying(100),
    lienjustificatifnuitee character varying(100)
);


ALTER TABLE public.mission OWNER TO stag;

--
-- Name: mission_idmission_seq; Type: SEQUENCE; Schema: public; Owner: stag
--

CREATE SEQUENCE public.mission_idmission_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mission_idmission_seq OWNER TO stag;

--
-- Name: mission_idmission_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: stag
--

ALTER SEQUENCE public.mission_idmission_seq OWNED BY public.mission.idmission;


--
-- Name: profil; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.profil (
    codeprofil character varying(10) NOT NULL,
    libelleprofil character varying(100) NOT NULL
);


ALTER TABLE public.profil OWNER TO stag;

--
-- Name: service; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.service (
    idservice character varying(10) NOT NULL,
    codeusine character varying(10) NOT NULL,
    libelleservice character varying(100) NOT NULL
);


ALTER TABLE public.service OWNER TO stag;

--
-- Name: type_activite; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.type_activite (
    codeactiv character varying(3) NOT NULL,
    libelleactiv character varying(100) NOT NULL
);


ALTER TABLE public.type_activite OWNER TO stag;

--
-- Name: type_client; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.type_client (
    codetypecli character varying(5) NOT NULL,
    libelletypecli character varying(100) NOT NULL
);


ALTER TABLE public.type_client OWNER TO stag;

--
-- Name: typologie_frais_reel; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.typologie_frais_reel (
    codetypo character varying(4) NOT NULL,
    libelletypo character varying(100) NOT NULL
);


ALTER TABLE public.typologie_frais_reel OWNER TO stag;

--
-- Name: usine; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.usine (
    codeusine character varying(10) NOT NULL,
    libelleusine character varying(100) NOT NULL,
    adresseusine character varying(255)
);


ALTER TABLE public.usine OWNER TO stag;

--
-- Name: voiture; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.voiture (
    immatriculation character varying(9) NOT NULL,
    puissanceadmin integer NOT NULL,
    idemp character varying(128) NOT NULL,
    autorisation boolean,
    certificatassurance character varying(100),
    dateautorisation date
);


ALTER TABLE public.voiture OWNER TO stag;

--
-- Name: zone_geographique; Type: TABLE; Schema: public; Owner: stag
--

CREATE TABLE public.zone_geographique (
    codezone character varying(2) NOT NULL,
    libellezone character varying(100) NOT NULL,
    tarifrepas numeric(10,2) NOT NULL,
    tarifnuitee numeric(10,2) NOT NULL
);


ALTER TABLE public.zone_geographique OWNER TO stag;

--
-- Name: demande_avance iddmdeavce; Type: DEFAULT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_avance ALTER COLUMN iddmdeavce SET DEFAULT nextval('public.demande_avance_iddmdeavce_seq'::regclass);


--
-- Name: demande_remboursement iddmderbsmt; Type: DEFAULT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_remboursement ALTER COLUMN iddmderbsmt SET DEFAULT nextval('public.demande_remboursement_iddmderbsmt_seq'::regclass);


--
-- Name: detail_frais_reel iddetailfrais; Type: DEFAULT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.detail_frais_reel ALTER COLUMN iddetailfrais SET DEFAULT nextval('public.detail_frais_reel_iddetailfrais_seq'::regclass);


--
-- Name: justificatif idjustificatif; Type: DEFAULT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.justificatif ALTER COLUMN idjustificatif SET DEFAULT nextval('public.justificatif_idjusticatif_seq'::regclass);


--
-- Name: mission idmission; Type: DEFAULT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission ALTER COLUMN idmission SET DEFAULT nextval('public.mission_idmission_seq'::regclass);


--
-- Data for Name: associer_avance_detail; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.associer_avance_detail (iddetailfrais, iddmdeavce) FROM stdin;
1	1
2	2
4	3
6	4
12	5
13	6
14	7
16	8
18	9
\.


--
-- Data for Name: associer_rbmt_detail; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.associer_rbmt_detail (iddmderbsmt, iddetailfrais) FROM stdin;
2	3
3	5
4	7
8	15
9	17
10	19
10	20
11	21
11	22
\.


--
-- Data for Name: bareme_kilometrique; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.bareme_kilometrique (puissanceadmin, tarif) FROM stdin;
3	0.409999996
4	0.493000001
5	0.542999983
6	0.568000019
7	0.595000029
\.


--
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.client (numsiret, codetypecli, nomclient) FROM stdin;
12345	CL1	Busson
23456	CL2	Collin
34568	CL3	Fontenier
45675	CL1	Aholou
56789	CL2	Razafindrakola
\.


--
-- Data for Name: demande_avance; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.demande_avance (iddmdeavce, idmission, montantdemande, nbrenuitee, justificatifnuitee, datedmande, montanttotalavance) FROM stdin;
2	7	150,00 €	5	\N	2022-01-15 00:00:00	100.00
3	5	750,00 €	8	hotelibis	2022-03-05 00:00:00	1425.00
4	9	220,00 €	2	SOFITEL	2022-04-01 00:00:00	220.00
1	1	50,00 €	\N	\N	2022-01-02 00:00:00	50.00
5	20	200,00 €	1	\N	2022-01-24 22:24:08	\N
6	21	150,00 €	3	\N	2022-01-24 22:32:09	\N
7	24	100,00 €	1	\N	2022-01-26 12:44:27	100.00
8	25	100,00 €	1	\N	2022-01-26 13:27:12	100.00
9	26	100,00 €	1	\N	2022-01-26 14:06:51	100.00
\.


--
-- Data for Name: demande_remboursement; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.demande_remboursement (iddmderbsmt, idmission, datedmde, nbrerepas, nbrenuitee, kmsparcourus, justificatifnuitee, immatriculation) FROM stdin;
2	7	2022-01-16 00:00:00	10	10	150	\N	ML985DC
1	1	2022-01-05 00:00:00	1	1	\N	RB-Novotel.pdf	\N
3	5	2022-03-22 00:00:00	15	15	\N	PLAISIRFrance-sofitel-facture.pdf	\N
4	9	2022-04-15 00:00:00	7	7	768	lemercier-hotel-ibis-facture.pdf	AB546CD
8	24	2022-01-26 12:50:13	2	1	0	PLAISIRFrance-sofitel-facture.pdf	\N
9	25	2022-01-26 13:29:32	4	1	0	RB-Novotel.pdf	\N
10	26	2022-01-26 14:07:57	4	1	0	RB-Novotel.pdf	\N
11	26	2022-01-26 14:07:57	4	1	0	RB-Novotel.pdf	\N
\.


--
-- Data for Name: detail_frais_reel; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.detail_frais_reel (iddetailfrais, codetypo, naturefrais, montanttotalfrais) FROM stdin;
1	TR15	billet train	50.00
2	TR20	Facture d'hôtel	100.00
3	TR20	Facture de restauration	150.00
4	TR10	billet avion	575.00
5	TR20	tickets de bus	50.00
6	AN10	parking	40.00
7	TR20	tickets de metro	8.00
12	AN30	HEBERGEMENT	200.00
13	AN30	HEBERGEMENT	150.00
14	AN30	HEBERGEMENT	100.00
15	AN20	DEPLACEMENT	25.00
16	TR15	DEPLACEMENT	150.00
17	AN20	DEPLACEMENT	80.00
18	TR15	DEPLACEMENT	150.00
19	AN20	DEPLACEMENT	80.00
20	AN10	DEPLACEMENT2	100.00
21	AN20	DEPLACEMENT	80.00
22	AN10	DEPLACEMENT2	100.00
\.


--
-- Data for Name: employe; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.employe (idemp, idservice, codeprofil, nom, prenom, courriel, motdepasse, civilite) FROM stdin;
US31001001	SCV1	P3	Lemercier	Valerie	valerie.lemercier@amp.fr	kiki31000	Mde
US31001002	SCV3	P1	banderas	felicien	felicien.banderas@amp.toulouse.fr	koko31001	Mr
US31001003	SCV4	P2	marechal	simone	simone.marechal@amp.toulouse.fr	lili1952	Mde
US31001004	SCV4	P2	tomy	luc	luc.tomy@amp.toulouse.fr	pinpin12	Mr
US37001001	SCV1	P3	chun	li	chun.li@amp.tours.fr	termal45	Mr
US37001002	SCV3	P1	danse	dominique	dominique.danse@amp.tours.fr	roule47	Mr
US37001003	SCV4	P2	plaisir	france	france.plaisir@amp.tours.fr	fanfan18	Mlle
US37001004	SCV4	P2	deluc	vincent	vincent.deluc@amp.tours.fr	Bibiche4+9	Mr
US37001005	SCV2	P3	duval	sandrine	sandrine.duval	trime18	Mde
US86001005	SCV2	P3	biquet	Jean-louis	Jean-louis.biquet@amp.poitiers.fr	tambour89	Mr
US86001004	SCV4	P2	terman	jean	jean.terman@amp.poitiers.fr	terman4x	Mr
US86001003	SCV4	P2	tampin	ludovic	ludovic.tampon@amp.poitiers.fr	gendre18	Mr
US86001002	SCV3	P1	grandon	pierre	pierre.grandon@amp.poitiers.fr	lpmpr12	Mr
US86001001	SCV1	P3	vincent	martine	martine.vincent@amp.orleans.fr	tg2869	Mlle
US80001003	SCV4	P2	gange	florence	florence.gange.amp.amiens.fr	tourism15	Mde
US80001004	SCV4	P2	tremintin	frederic	frederici.tremintin@amp.amiens.fr	team52	Mr
US80001002	SCV3	P1	grave	sylvie	sylvie.grave@amp.amiens.fr	tony63	Mde
US80001001	SCV1	P3	faron	bastien	bastien.faron@amp.amiens.fr	troncon14	Mr
US45001001	SCV1	P3	ramala	rachid	rachid.ramala@amp.orleans.fr	dudu12	Mr
US45001002	SCV3	P1	ducher	sebastien	sebastien.ducher@amp.orleans.fr	jiji46	Mr
US45001003	SCV4	P2	parvis	camille	camille.parvis@amp.orleans.fr	titi17	Mde
US45001004	SCV4	P2	thomas	fabien	fabien.thomas@amp.orleans.fr	loulou92	Mr
US45001005	SCV2	P3	buisson	stephane	stephane.buisson@amp.orleans.fr	5lom46	Mr
US31001005	SVC2	P3	vilain	guillaume	guillaume.vilain@amp.toulouse.fr	lolo45	Mr
US80001005	SVC2	P3	boulette	raphael	raphael.boulette@amp.amiens.fr	jambon18	Mr
US80001000	SVC2	P4	AHOLOU	Christian	christian.aholou@yahoo.com	christ	Mr
\.


--
-- Data for Name: etat_avcmt_avance; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.etat_avcmt_avance (iddmdeavce, codeetat, datevaletat) FROM stdin;
1	V25	2022-01-02                      
2	V20	2022-01-16                      
2	V10	2022-01-14                      
3	V25	2022-03-10                      
3	V15	2022-01-05                      
4	V20	2022-04-06                      
5	V10	\N
6	V10	\N
7	V10	\N
8	V10	\N
9	V10	\N
\.


--
-- Data for Name: etat_avcmt_rbrsmt; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.etat_avcmt_rbrsmt (codeetat, iddmderbsmt, datevaletat) FROM stdin;
V10	2	2022-01-15 00:00:00
V20	3	2022-03-27 00:00:00
V10	4	2022-04-15 00:00:00
V15	1	2022-01-05 00:00:00
V10	8	\N
V10	9	\N
V10	10	\N
V10	11	\N
\.


--
-- Data for Name: etrechef; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.etrechef (idemp, idemp_1, idemp_chef_de_service) FROM stdin;
\.


--
-- Data for Name: index_etat_avancement; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.index_etat_avancement (codeetat, libelleetat) FROM stdin;
V15	Valide CDS
V25	Valide RH
V30	Remboursé
V10	A valider CS
V20	A valider RH
\.


--
-- Data for Name: justificatif; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.justificatif (idjustificatif, iddetailfrais, libellejustificatif, nomfichier) FROM stdin;
4	6	reservation parking	US37001003-pk.pdf
10	12	FACTURE D'HOTEL	lemercier-hotel-ibis-facture.pdf
11	13	FACTURE D'HOTEL	lemercier-hotel-ibis-facture.pdf
1	1	facture billet train	US80001005-billetTrain.pdf
2	4	facture billet avion	US31001001-avion.pdf
3	5	renfe	US31001001-renfe.pdf
5	7	ratp	US37001003-justifratp.pdf
12	14	FACTURE D'HOTEL	PLAISIRFrance-sofitel-facture.pdf
13	15	LOCATION DE VOITURE	US37001003-justifratp.pdf
14	16	BILLET  TRAIN	US80001005-billetTrain.pdf
15	17	LOCATION DE VOITURETY	US37001003-justifratp.pdf
16	18	BILLET  TRAIN	US80001005-billetTrain.pdf
17	19	LOCATION DE VOITURE	US31001001-renfe.pdf
18	20	TICKET PEAGE	US37001003-parking.pdf
19	21	LOCATION DE VOITURE	US31001001-renfe.pdf
20	22	TICKET PEAGE	US37001003-parking.pdf
\.


--
-- Data for Name: mission; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.mission (idmission, idemp, codezone, numsiret, codeactiv, dateheuredebut, dateheurefin, numordremission, lienordremission, dateheuredepart, dateheureretour, codepostal, adresse, ville, lienjustificatifnuitee) FROM stdin;
9	US37001003	Z1	34568	C03	2022-04-11 07:00:00	2022-04-13 20:00:00	3	https://amp.com/archives/odmiss3.pdf	2022-04-10 19:00:00	2022-04-13 23:00:00	31000	avenue charles de gaule	Toulouse	\N
19	US80001005	Z1	\N	C03	2022-01-17 08:00:00	2022-01-21 17:00:00	159	91830-DIAP-01-extrait_2.pdf	\N	\N	75300	75 Avenue Charles de gaules	PARIS	\N
20	US80001000	Z4	\N	C03	2022-01-24 08:00:00	2022-01-24 21:00:00	145	91830-DIAP-01-extrait.pdf	\N	\N	229	145 Rue Haie vive	Cotonou	\N
21	US80001000	Z3	\N	C01	2022-01-19 08:00:00	2022-01-22 19:00:00	1450	91830-DIAP-01-extrait_2.pdf	\N	\N	1002	Belgique	Aéroport Bruxelles	\N
22	US80001000	Z3	\N	C02	2022-01-19 08:00:00	2022-01-19 20:00:00	1451	91830-DIAP-01-extrait_2.pdf	\N	\N	13560	Norvege	Norvege	\N
23	US80001000	Z1	\N	C02	2022-01-20 08:00:00	2022-01-20 21:00:00	1452	91830-DIAP-01-extrait_2.pdf	\N	\N	75300	75 Avenue Charles de gaules	PARIS	\N
24	US80001005	Z1	\N	C02	2022-01-02 08:00:00	2022-02-02 21:00:00	4526369	odmiss3.pdf	\N	\N	75300	75 Avenue Charles de gaules	PARIS	\N
25	US80001005	Z2	12345	C01	2022-02-01 13:25:00	2022-02-02 18:00:00	159	odmiss2.pdf	\N	\N	75300	75 Avenue Charles de gaules	PARIS	\N
1	US80001005	Z2	12345	C01	2022-01-04 11:00:00	2022-01-04 17:00:00	1	91830-DIAP-01-extrait.pdf	2022-01-04 07:00:00	2022-01-04 18:00:00	31000	avenue charles de gaule	Toulouse	\N
5	US31001001	Z3	23456	C02	2022-03-12 11:00:00	2022-03-19 19:00:00	2	91830-DIAP-01-extrait.pdf	2022-03-11 18:00:00	2022-03-19 19:00:00	31000	avenue charles de gaule	Toulouse	\N
8	US45001003	Z3	12345	C02	2022-01-15 18:00:00	2022-01-16 20:00:00	123456781	odmiss2.pdf	2022-01-15 23:00:00	2022-01-16 23:00:00	1002	1001 aéroport de Bruxelles	09	\N
7	US45001003	Z1	\N	C02	2022-01-15 18:00:00	2022-01-16 20:00:00	123456780	odmiss2.pdf	\N	\N	75300	75 Avenue Charles de gaules	01	\N
6	US45001003	Z1	\N	C02	2022-01-15 18:00:00	2022-01-15 20:00:00	123456789	odmiss3.pdf	2022-01-15 20:01:05	2022-01-15 20:01:05	75300	75 Avenue Charles de gaules	01	\N
4	US80001000	Z2	45675	C02	2022-01-15 03:00:00	2022-01-16 04:00:00	45214792	odmiss3.pdf	2022-01-15 03:00:00	2022-01-16 04:00:00	31300	93 Avenue de Lombez	07	BBB
3	US45001003	Z1	45675	C01	2022-01-15 02:00:00	2022-01-16 02:00:00	45214790	odmiss3.pdf	2022-01-15 02:00:00	2022-01-16 04:00:00	75001	24 rue saint honoré	paris	BBB
2	US45001003	Z1	45675	C01	2022-01-15 01:43:00	2022-01-15 01:43:00	45214789	odmiss2.pdf	2022-01-15 01:43:00	2022-01-15 01:43:00	8870	passeig de pujades 23	sitges	BBB
26	US80001005	Z2	34568	C01	2022-01-27 09:00:00	2022-01-27 17:00:00	458	odmiss2.pdf	\N	\N	31300	Toulouse	Toulouse	\N
\.


--
-- Data for Name: profil; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.profil (codeprofil, libelleprofil) FROM stdin;
P1	technicien
P2	vendeur
P3	administratif
P4	Administrateur
\.


--
-- Data for Name: service; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.service (idservice, codeusine, libelleservice) FROM stdin;
SVC1	US31001	RH
SVC20	US86001	Commercial
SVC19	US80001	Commercial
SVC18	US45001	Commercial
SVC17	US37001	Commercial
SVC16	US31001	Commercial
SVC15	US86001	Production
SVC14	US80001	Production
SVC13	US45001	Production
SVC12	US37001	Production
SVC11	US31001	Production
SVC10	US86001	Logistique
SVC9	US80001	Logistique
SVC8	US45001	Logistique
SVC7	US37001	Logistique
SVC6	US31001	Logistique
SVC5	US86001	RH
SVC4	US80001	RH
SVC3	US45001	RH
SVC2	US37001	RH
\.


--
-- Data for Name: type_activite; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.type_activite (codeactiv, libelleactiv) FROM stdin;
C01	Installation / Maintennace
C02	Prospective / Vente
C03	Reunion / Seminaire
\.


--
-- Data for Name: type_client; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.type_client (codetypecli, libelletypecli) FROM stdin;
CL1	Artisans
CL2	PME
CL3	Grands Groupes
\.


--
-- Data for Name: typologie_frais_reel; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.typologie_frais_reel (codetypo, libelletypo) FROM stdin;
TR10	Transport Avion
TR15	Transport Train
TR20	Transport Autre
AN10	Annexe Parking
AN15	Annexe Péage
AN20	Annexe Location Véhicule
AN30	Annexe Autre
\.


--
-- Data for Name: usine; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.usine (codeusine, libelleusine, adresseusine) FROM stdin;
US31001	ToulAMP	1 Rue Emile Zola, 31000 Toulouse
US45001	OrleAMP	3 Bd de Chateaudun 45000 Orléans
US86001	PoitAMP	3 Rue Albert 1er 86000 Poitiers
US37001	TourAMP	8 Rue de la Republique 37000 Tours
US80001	AmieAMP	12 Rue du Général Beuret 80000 Amiens
\.


--
-- Data for Name: voiture; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.voiture (immatriculation, puissanceadmin, idemp, autorisation, certificatassurance, dateautorisation) FROM stdin;
AA229BB	3	US31001001	t	AXA	2021-12-15
AA409BT	3	US31001003	f	AXA	\N
AB546CD	4	US37001003	t	SOGEASSUR	2021-01-15
CD125DF	5	US45001005	f	SOGEASSUR	\N
DR589GF	6	US80001003	t	AXA	2021-06-05
GF993AB	7	US86001001	t	ACTIVE ASSURANCE	2021-04-01
GP873MP	5	US86001003	t	AXA	2021-07-01
GF597PP	3	US80001002	t	DIRECT ASSURANCE	2020-07-01
AQ841DF	7	US37001004	f	GAN ASSURANCE	\N
PM234KR	4	US86001001	t	DIRECT ASSURANCE	2020-06-01
BV4060RB	5	US80001000	\N	DIRECT ASSURANCE	2020-12-31
ML985DC	6	US45001003	t	AXA	2020-01-15
\.


--
-- Data for Name: zone_geographique; Type: TABLE DATA; Schema: public; Owner: stag
--

COPY public.zone_geographique (codezone, libellezone, tarifrepas, tarifnuitee) FROM stdin;
Z1	Paris et region parisienne	25.00	90.00
Z2	province	20.00	70.00
Z3	UE	25.00	100.00
Z4	Etranger hors UE	30.00	120.00
\.


--
-- Name: demande_avance_iddmdeavce_seq; Type: SEQUENCE SET; Schema: public; Owner: stag
--

SELECT pg_catalog.setval('public.demande_avance_iddmdeavce_seq', 9, true);


--
-- Name: demande_remboursement_iddmderbsmt_seq; Type: SEQUENCE SET; Schema: public; Owner: stag
--

SELECT pg_catalog.setval('public.demande_remboursement_iddmderbsmt_seq', 11, true);


--
-- Name: detail_frais_reel_iddetailfrais_seq; Type: SEQUENCE SET; Schema: public; Owner: stag
--

SELECT pg_catalog.setval('public.detail_frais_reel_iddetailfrais_seq', 22, true);


--
-- Name: justificatif_idjusticatif_seq; Type: SEQUENCE SET; Schema: public; Owner: stag
--

SELECT pg_catalog.setval('public.justificatif_idjusticatif_seq', 20, true);


--
-- Name: mission_idmission_seq; Type: SEQUENCE SET; Schema: public; Owner: stag
--

SELECT pg_catalog.setval('public.mission_idmission_seq', 26, true);


--
-- Name: associer_avance_detail pk_associer_avance_detail; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_avance_detail
    ADD CONSTRAINT pk_associer_avance_detail PRIMARY KEY (iddetailfrais, iddmdeavce);


--
-- Name: associer_rbmt_detail pk_associer_rbmt_detail; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_rbmt_detail
    ADD CONSTRAINT pk_associer_rbmt_detail PRIMARY KEY (iddmderbsmt, iddetailfrais);


--
-- Name: bareme_kilometrique pk_bareme_kilometrique; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.bareme_kilometrique
    ADD CONSTRAINT pk_bareme_kilometrique PRIMARY KEY (puissanceadmin);


--
-- Name: client pk_client; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT pk_client PRIMARY KEY (numsiret);


--
-- Name: demande_avance pk_demande_avance; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_avance
    ADD CONSTRAINT pk_demande_avance PRIMARY KEY (iddmdeavce);


--
-- Name: demande_remboursement pk_demande_remboursement; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_remboursement
    ADD CONSTRAINT pk_demande_remboursement PRIMARY KEY (iddmderbsmt);


--
-- Name: detail_frais_reel pk_detail_frais_reel; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.detail_frais_reel
    ADD CONSTRAINT pk_detail_frais_reel PRIMARY KEY (iddetailfrais);


--
-- Name: employe pk_employe; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.employe
    ADD CONSTRAINT pk_employe PRIMARY KEY (idemp);


--
-- Name: etat_avcmt_avance pk_etat_avcmt_avance; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_avance
    ADD CONSTRAINT pk_etat_avcmt_avance PRIMARY KEY (iddmdeavce, codeetat);


--
-- Name: etat_avcmt_rbrsmt pk_etat_avcmt_rbrsmt; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_rbrsmt
    ADD CONSTRAINT pk_etat_avcmt_rbrsmt PRIMARY KEY (codeetat, iddmderbsmt);


--
-- Name: etrechef pk_etrechef; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etrechef
    ADD CONSTRAINT pk_etrechef PRIMARY KEY (idemp, idemp_1);


--
-- Name: index_etat_avancement pk_index_etat_avancement; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.index_etat_avancement
    ADD CONSTRAINT pk_index_etat_avancement PRIMARY KEY (codeetat);


--
-- Name: justificatif pk_justificatif; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.justificatif
    ADD CONSTRAINT pk_justificatif PRIMARY KEY (idjustificatif);


--
-- Name: mission pk_mission; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission
    ADD CONSTRAINT pk_mission PRIMARY KEY (idmission);


--
-- Name: profil pk_profil; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.profil
    ADD CONSTRAINT pk_profil PRIMARY KEY (codeprofil);


--
-- Name: service pk_service; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.service
    ADD CONSTRAINT pk_service PRIMARY KEY (idservice);


--
-- Name: type_activite pk_type_activite; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.type_activite
    ADD CONSTRAINT pk_type_activite PRIMARY KEY (codeactiv);


--
-- Name: type_client pk_type_client; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.type_client
    ADD CONSTRAINT pk_type_client PRIMARY KEY (codetypecli);


--
-- Name: typologie_frais_reel pk_typologie_frais_reel; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.typologie_frais_reel
    ADD CONSTRAINT pk_typologie_frais_reel PRIMARY KEY (codetypo);


--
-- Name: usine pk_usine; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.usine
    ADD CONSTRAINT pk_usine PRIMARY KEY (codeusine);


--
-- Name: voiture pk_voiture; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.voiture
    ADD CONSTRAINT pk_voiture PRIMARY KEY (immatriculation);


--
-- Name: zone_geographique pk_zone_geographique; Type: CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.zone_geographique
    ADD CONSTRAINT pk_zone_geographique PRIMARY KEY (codezone);


--
-- Name: i_fk_associer_avance_detail_d1; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_associer_avance_detail_d1 ON public.associer_avance_detail USING btree (iddmdeavce);


--
-- Name: i_fk_associer_avance_detail_de; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_associer_avance_detail_de ON public.associer_avance_detail USING btree (iddetailfrais);


--
-- Name: i_fk_associer_rbmt_detail_dema; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_associer_rbmt_detail_dema ON public.associer_rbmt_detail USING btree (iddmderbsmt);


--
-- Name: i_fk_associer_rbmt_detail_deta; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_associer_rbmt_detail_deta ON public.associer_rbmt_detail USING btree (iddetailfrais);


--
-- Name: i_fk_client_type_client; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_client_type_client ON public.client USING btree (codetypecli);


--
-- Name: i_fk_demande_avance_mission; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_demande_avance_mission ON public.demande_avance USING btree (idmission);


--
-- Name: i_fk_demande_remboursement_mis; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_demande_remboursement_mis ON public.demande_remboursement USING btree (idmission);


--
-- Name: i_fk_detail_frais_reel_typolog; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_detail_frais_reel_typolog ON public.detail_frais_reel USING btree (codetypo);


--
-- Name: i_fk_employe_profil; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_employe_profil ON public.employe USING btree (codeprofil);


--
-- Name: i_fk_employe_service; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_employe_service ON public.employe USING btree (idservice);


--
-- Name: i_fk_etat_avcmt_avance_demande; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etat_avcmt_avance_demande ON public.etat_avcmt_avance USING btree (iddmdeavce);


--
-- Name: i_fk_etat_avcmt_avance_index_e; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etat_avcmt_avance_index_e ON public.etat_avcmt_avance USING btree (codeetat);


--
-- Name: i_fk_etat_avcmt_rbrsmt_demande; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etat_avcmt_rbrsmt_demande ON public.etat_avcmt_rbrsmt USING btree (iddmderbsmt);


--
-- Name: i_fk_etat_avcmt_rbrsmt_index_e; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etat_avcmt_rbrsmt_index_e ON public.etat_avcmt_rbrsmt USING btree (codeetat);


--
-- Name: i_fk_etrechef_employe; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etrechef_employe ON public.etrechef USING btree (idemp);


--
-- Name: i_fk_etrechef_employe_2; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etrechef_employe_2 ON public.etrechef USING btree (idemp_chef_de_service);


--
-- Name: i_fk_etrechef_employe_3; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_etrechef_employe_3 ON public.etrechef USING btree (idemp_1);


--
-- Name: i_fk_justificatif_detail_frais; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_justificatif_detail_frais ON public.justificatif USING btree (iddetailfrais);


--
-- Name: i_fk_mission_client; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_mission_client ON public.mission USING btree (numsiret);


--
-- Name: i_fk_mission_employe; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_mission_employe ON public.mission USING btree (idemp);


--
-- Name: i_fk_mission_type_activite; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_mission_type_activite ON public.mission USING btree (codeactiv);


--
-- Name: i_fk_mission_zone_geographique; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_mission_zone_geographique ON public.mission USING btree (codezone);


--
-- Name: i_fk_service_usine; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_service_usine ON public.service USING btree (codeusine);


--
-- Name: i_fk_voiture_bareme_kilometriq; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_voiture_bareme_kilometriq ON public.voiture USING btree (puissanceadmin);


--
-- Name: i_fk_voiture_employe; Type: INDEX; Schema: public; Owner: stag
--

CREATE INDEX i_fk_voiture_employe ON public.voiture USING btree (idemp);


--
-- Name: associer_avance_detail fk_associer_avance_detail_demand; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_avance_detail
    ADD CONSTRAINT fk_associer_avance_detail_demand FOREIGN KEY (iddmdeavce) REFERENCES public.demande_avance(iddmdeavce);


--
-- Name: associer_avance_detail fk_associer_avance_detail_detail; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_avance_detail
    ADD CONSTRAINT fk_associer_avance_detail_detail FOREIGN KEY (iddetailfrais) REFERENCES public.detail_frais_reel(iddetailfrais);


--
-- Name: associer_rbmt_detail fk_associer_rbmt_detail_demande_; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_rbmt_detail
    ADD CONSTRAINT fk_associer_rbmt_detail_demande_ FOREIGN KEY (iddmderbsmt) REFERENCES public.demande_remboursement(iddmderbsmt);


--
-- Name: associer_rbmt_detail fk_associer_rbmt_detail_detail_f; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.associer_rbmt_detail
    ADD CONSTRAINT fk_associer_rbmt_detail_detail_f FOREIGN KEY (iddetailfrais) REFERENCES public.detail_frais_reel(iddetailfrais);


--
-- Name: client fk_client_type_client; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT fk_client_type_client FOREIGN KEY (codetypecli) REFERENCES public.type_client(codetypecli);


--
-- Name: demande_avance fk_demande_avance_mission; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_avance
    ADD CONSTRAINT fk_demande_avance_mission FOREIGN KEY (idmission) REFERENCES public.mission(idmission);


--
-- Name: demande_remboursement fk_demande_remboursement_mission; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_remboursement
    ADD CONSTRAINT fk_demande_remboursement_mission FOREIGN KEY (idmission) REFERENCES public.mission(idmission);


--
-- Name: demande_remboursement fk_demande_remboursement_voiture; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.demande_remboursement
    ADD CONSTRAINT fk_demande_remboursement_voiture FOREIGN KEY (immatriculation) REFERENCES public.voiture(immatriculation);


--
-- Name: detail_frais_reel fk_detail_frais_reel_typologie_f; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.detail_frais_reel
    ADD CONSTRAINT fk_detail_frais_reel_typologie_f FOREIGN KEY (codetypo) REFERENCES public.typologie_frais_reel(codetypo);


--
-- Name: employe fk_employe_profil; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.employe
    ADD CONSTRAINT fk_employe_profil FOREIGN KEY (codeprofil) REFERENCES public.profil(codeprofil);


--
-- Name: etat_avcmt_avance fk_etat_avcmt_avance_demande_ava; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_avance
    ADD CONSTRAINT fk_etat_avcmt_avance_demande_ava FOREIGN KEY (iddmdeavce) REFERENCES public.demande_avance(iddmdeavce);


--
-- Name: etat_avcmt_avance fk_etat_avcmt_avance_index_etat_; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_avance
    ADD CONSTRAINT fk_etat_avcmt_avance_index_etat_ FOREIGN KEY (codeetat) REFERENCES public.index_etat_avancement(codeetat);


--
-- Name: etat_avcmt_rbrsmt fk_etat_avcmt_rbrsmt_demande_rem; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_rbrsmt
    ADD CONSTRAINT fk_etat_avcmt_rbrsmt_demande_rem FOREIGN KEY (iddmderbsmt) REFERENCES public.demande_remboursement(iddmderbsmt);


--
-- Name: etat_avcmt_rbrsmt fk_etat_avcmt_rbrsmt_index_etat_; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etat_avcmt_rbrsmt
    ADD CONSTRAINT fk_etat_avcmt_rbrsmt_index_etat_ FOREIGN KEY (codeetat) REFERENCES public.index_etat_avancement(codeetat);


--
-- Name: etrechef fk_etrechef_employe; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etrechef
    ADD CONSTRAINT fk_etrechef_employe FOREIGN KEY (idemp) REFERENCES public.employe(idemp);


--
-- Name: etrechef fk_etrechef_employe_2; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etrechef
    ADD CONSTRAINT fk_etrechef_employe_2 FOREIGN KEY (idemp_chef_de_service) REFERENCES public.employe(idemp);


--
-- Name: etrechef fk_etrechef_employe_3; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.etrechef
    ADD CONSTRAINT fk_etrechef_employe_3 FOREIGN KEY (idemp_1) REFERENCES public.employe(idemp);


--
-- Name: justificatif fk_justificatif_detail_frais_ree; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.justificatif
    ADD CONSTRAINT fk_justificatif_detail_frais_ree FOREIGN KEY (iddetailfrais) REFERENCES public.detail_frais_reel(iddetailfrais);


--
-- Name: mission fk_mission_client; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission
    ADD CONSTRAINT fk_mission_client FOREIGN KEY (numsiret) REFERENCES public.client(numsiret);


--
-- Name: mission fk_mission_employe; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission
    ADD CONSTRAINT fk_mission_employe FOREIGN KEY (idemp) REFERENCES public.employe(idemp);


--
-- Name: mission fk_mission_type_activite; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission
    ADD CONSTRAINT fk_mission_type_activite FOREIGN KEY (codeactiv) REFERENCES public.type_activite(codeactiv);


--
-- Name: mission fk_mission_zone_geographique; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.mission
    ADD CONSTRAINT fk_mission_zone_geographique FOREIGN KEY (codezone) REFERENCES public.zone_geographique(codezone);


--
-- Name: service fk_service_usine; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.service
    ADD CONSTRAINT fk_service_usine FOREIGN KEY (codeusine) REFERENCES public.usine(codeusine);


--
-- Name: voiture fk_voiture_bareme_kilometrique; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.voiture
    ADD CONSTRAINT fk_voiture_bareme_kilometrique FOREIGN KEY (puissanceadmin) REFERENCES public.bareme_kilometrique(puissanceadmin);


--
-- Name: voiture fk_voiture_employe; Type: FK CONSTRAINT; Schema: public; Owner: stag
--

ALTER TABLE ONLY public.voiture
    ADD CONSTRAINT fk_voiture_employe FOREIGN KEY (idemp) REFERENCES public.employe(idemp);


--
-- PostgreSQL database dump complete
--

