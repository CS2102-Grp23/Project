--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.1
-- Dumped by pg_dump version 9.6.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: add_contribute(integer, character varying, money); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION add_contribute(integer, character varying, money) RETURNS void
    LANGUAGE plpgsql
    AS $_$
    BEGIN
      INSERT INTO contribute as con VALUES ($1, $2, $3)
      ON CONFLICT ON CONSTRAINT contribute_pkey
      DO UPDATE SET amount = con.amount + $3 WHERE con."projectID" = $1 AND con.username = $2;
    END;
    $_$;


ALTER FUNCTION public.add_contribute(integer, character varying, money) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: contribute; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE contribute (
    "projectID" integer NOT NULL,
    username character varying(254) NOT NULL,
    amount money NOT NULL
);


ALTER TABLE contribute OWNER TO postgres;

--
-- Name: COLUMN contribute."projectID"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN contribute."projectID" IS 'foreign key constraint';


--
-- Name: COLUMN contribute.username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN contribute.username IS 'foreign key constraint';


--
-- Name: project; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE project (
    "projectID" integer NOT NULL,
    title character varying(254) NOT NULL,
    description character varying(508),
    category character varying(254),
    "startDate" date NOT NULL,
    "endDate" date NOT NULL,
    "targetAmount" money NOT NULL,
    "imageURL" character varying(254),
    username character varying(254) NOT NULL,
    CONSTRAINT chk_category CHECK (((category)::text = ANY ((ARRAY['Art'::character varying, 'Comic'::character varying, 'Crafts'::character varying, 'Dance'::character varying, 'Design'::character varying, 'Fashion'::character varying, 'Film and Video'::character varying, 'Food'::character varying, 'Games'::character varying, 'Journalism'::character varying, 'Music'::character varying, 'Photography'::character varying, 'Publishing'::character varying, 'Technology'::character varying, 'Theather'::character varying])::text[]))),
    CONSTRAINT chk_dates CHECK (("startDate" < "endDate"))
);


ALTER TABLE project OWNER TO postgres;

--
-- Name: COLUMN project."projectID"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN project."projectID" IS '4-byte signed integer that is auto-incrementing';


--
-- Name: COLUMN project.category; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN project.category IS 'constraint check if belong to { pre-defined categories }';


--
-- Name: COLUMN project."endDate"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN project."endDate" IS 'constraint check if endDate > startDate';


--
-- Name: COLUMN project."imageURL"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN project."imageURL" IS '##during retrieval if null use default image?';


--
-- Name: COLUMN project.username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN project.username IS 'foreign key constraint';


--
-- Name: project_projectID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "project_projectID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "project_projectID_seq" OWNER TO postgres;

--
-- Name: project_projectID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "project_projectID_seq" OWNED BY project."projectID";


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE users (
    username character varying(24) NOT NULL,
    password character(64) NOT NULL,
    accesslevel boolean DEFAULT false NOT NULL,
    email character varying(80) NOT NULL,
    name character varying(254) NOT NULL,
    "creditCard" character varying(19),
    nationality character varying(30),
    CONSTRAINT chk_nationality CHECK (((nationality)::text = ANY (ARRAY[('Afghan'::character varying)::text, ('Albanian'::character varying)::text, ('Algerian'::character varying)::text, ('American'::character varying)::text, ('Andorran'::character varying)::text, ('Angolan'::character varying)::text, ('Antiguans'::character varying)::text, ('Argentinean'::character varying)::text, ('Armenian'::character varying)::text, ('Australian'::character varying)::text, ('Austrian'::character varying)::text, ('Azerbaijani'::character varying)::text, ('Bahamian'::character varying)::text, ('Bahraini'::character varying)::text, ('Bangladeshi'::character varying)::text, ('Barbadian'::character varying)::text, ('Barbudans'::character varying)::text, ('Batswana'::character varying)::text, ('Belarusian'::character varying)::text, ('Belgian'::character varying)::text, ('Belizean'::character varying)::text, ('Beninese'::character varying)::text, ('Bhutanese'::character varying)::text, ('Bolivian'::character varying)::text, ('Bosnian'::character varying)::text, ('Brazilian'::character varying)::text, ('British'::character varying)::text, ('Bruneian'::character varying)::text, ('Bulgarian'::character varying)::text, ('Burkinabe'::character varying)::text, ('Burmese'::character varying)::text, ('Burundian'::character varying)::text, ('Cambodian'::character varying)::text, ('Cameroonian'::character varying)::text, ('Canadian'::character varying)::text, ('Cape Verdean'::character varying)::text, ('Central African'::character varying)::text, ('Chadian'::character varying)::text, ('Chilean'::character varying)::text, ('Chinese'::character varying)::text, ('Colombian'::character varying)::text, ('Comoran'::character varying)::text, ('Congolese'::character varying)::text, ('Costa Rican'::character varying)::text, ('Croatian'::character varying)::text, ('Cuban'::character varying)::text, ('Cypriot'::character varying)::text, ('Czech'::character varying)::text, ('Danish'::character varying)::text, ('Djibouti'::character varying)::text, ('Dominican'::character varying)::text, ('Dutch'::character varying)::text, ('East Timorese'::character varying)::text, ('Ecuadorean'::character varying)::text, ('Egyptian'::character varying)::text, ('Emirian'::character varying)::text, ('Equatorial Guinean'::character varying)::text, ('Eritrean'::character varying)::text, ('Estonian'::character varying)::text, ('Ethiopian'::character varying)::text, ('Fijian'::character varying)::text, ('Filipino'::character varying)::text, ('Finnish'::character varying)::text, ('French'::character varying)::text, ('Gabonese'::character varying)::text, ('Gambian'::character varying)::text, ('Georgian'::character varying)::text, ('German'::character varying)::text, ('Ghanaian'::character varying)::text, ('Greek'::character varying)::text, ('Grenadian'::character varying)::text, ('Guatemalan'::character varying)::text, ('Guinea-Bissauan'::character varying)::text, ('Guinean'::character varying)::text, ('Guyanese'::character varying)::text, ('Haitian'::character varying)::text, ('Herzegovinian'::character varying)::text, ('Honduran'::character varying)::text, ('Hungarian'::character varying)::text, ('Icelander'::character varying)::text, ('Indian'::character varying)::text, ('Indonesian'::character varying)::text, ('Iranian'::character varying)::text, ('Iraqi'::character varying)::text, ('Irish'::character varying)::text, ('Israeli'::character varying)::text, ('Italian'::character varying)::text, ('Ivorian'::character varying)::text, ('Jamaican'::character varying)::text, ('Japanese'::character varying)::text, ('Jordanian'::character varying)::text, ('Kazakhstani'::character varying)::text, ('Kenyan'::character varying)::text, ('Kittian and Nevisian'::character varying)::text, ('Kuwaiti'::character varying)::text, ('Kyrgyz'::character varying)::text, ('Laotian'::character varying)::text, ('Latvian'::character varying)::text, ('Lebanese'::character varying)::text, ('Liberian'::character varying)::text, ('Libyan'::character varying)::text, ('Liechtensteiner'::character varying)::text, ('Lithuanian'::character varying)::text, ('Luxembourger'::character varying)::text, ('Macedonian'::character varying)::text, ('Malagasy'::character varying)::text, ('Malawian'::character varying)::text, ('Malaysian'::character varying)::text, ('Maldivan'::character varying)::text, ('Malian'::character varying)::text, ('Maltese'::character varying)::text, ('Marshallese'::character varying)::text, ('Mauritanian'::character varying)::text, ('Mauritian'::character varying)::text, ('Mexican'::character varying)::text, ('Micronesian'::character varying)::text, ('Moldovan'::character varying)::text, ('Monacan'::character varying)::text, ('Mongolian'::character varying)::text, ('Moroccan'::character varying)::text, ('Mosotho'::character varying)::text, ('Motswana'::character varying)::text, ('Mozambican'::character varying)::text, ('Namibian'::character varying)::text, ('Nauruan'::character varying)::text, ('Nepalese'::character varying)::text, ('New Zealander'::character varying)::text, ('Ni-Vanuatu'::character varying)::text, ('Nicaraguan'::character varying)::text, ('Nigerien'::character varying)::text, ('North Korean'::character varying)::text, ('Northern Irish'::character varying)::text, ('Norwegian'::character varying)::text, ('Omani'::character varying)::text, ('Pakistani'::character varying)::text, ('Palauan'::character varying)::text, ('Panamanian'::character varying)::text, ('Papua New Guinean'::character varying)::text, ('Paraguayan'::character varying)::text, ('Peruvian'::character varying)::text, ('Polish'::character varying)::text, ('Portuguese'::character varying)::text, ('Qatari'::character varying)::text, ('Romanian'::character varying)::text, ('Russian'::character varying)::text, ('Rwandan'::character varying)::text, ('Saint Lucian'::character varying)::text, ('Salvadoran'::character varying)::text, ('Samoan'::character varying)::text, ('San Marinese'::character varying)::text, ('Sao Tomean'::character varying)::text, ('Saudi'::character varying)::text, ('Scottish'::character varying)::text, ('Senegalese'::character varying)::text, ('Serbian'::character varying)::text, ('Seychellois'::character varying)::text, ('Sierra Leonean'::character varying)::text, ('Singaporean'::character varying)::text, ('Slovakian'::character varying)::text, ('Slovenian'::character varying)::text, ('Solomon Islander'::character varying)::text, ('Somali'::character varying)::text, ('South African'::character varying)::text, ('South Korean'::character varying)::text, ('Spanish'::character varying)::text, ('Sri Lankan'::character varying)::text, ('Sudanese'::character varying)::text, ('Surinamer'::character varying)::text, ('Swazi'::character varying)::text, ('Swedish'::character varying)::text, ('Swiss'::character varying)::text, ('Syrian'::character varying)::text, ('Taiwanese'::character varying)::text, ('Tajik'::character varying)::text, ('Tanzanian'::character varying)::text, ('Thai'::character varying)::text, ('Togolese'::character varying)::text, ('Tongan'::character varying)::text, ('Trinidadian or Tobagonian'::character varying)::text, ('Tunisian'::character varying)::text, ('Turkish'::character varying)::text, ('Tuvaluan'::character varying)::text, ('Ugandan'::character varying)::text, ('Ukrainian'::character varying)::text, ('Uruguayan'::character varying)::text, ('Uzbekistani'::character varying)::text, ('Venezuelan'::character varying)::text, ('Vietnamese'::character varying)::text, ('Welsh'::character varying)::text, ('Yemenite'::character varying)::text, ('Zambian'::character varying)::text, ('Zimbabwean'::character varying)::text])))
);


ALTER TABLE users OWNER TO postgres;

--
-- Name: TABLE users; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE users IS 'username, password, accesslevel';


--
-- Name: COLUMN users.password; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN users.password IS 'hashed password';


--
-- Name: COLUMN users.accesslevel; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN users.accesslevel IS 'admin(true) or user(false)';


--
-- Name: COLUMN users.nationality; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN users.nationality IS 'check nationality';


--
-- Name: project projectID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY project ALTER COLUMN "projectID" SET DEFAULT nextval('"project_projectID_seq"'::regclass);


--
-- Data for Name: contribute; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY contribute ("projectID", username, amount) FROM stdin;
1	test22	+$4.00
17	test22	+$7.00
67	test16	+$3.00
12	test9	+$4.00
31	test11	+$3.00
11	test25	+$2.00
37	test29	+$6.00
87	test22	+$2.00
11	test12	+$1.00
38	test28	+$3.00
60	test6	+$4.00
110	test3	+$6.00
90	test27	+$2.00
53	test10	+$1.00
59	test21	+$8.00
40	test7	+$1.00
27	test25	+$3.00
56	test2	+$3.00
37	test21	+$5.00
35	test9	+$7.00
14	test22	+$3.00
120	test6	+$1.00
38	test1	+$3.00
50	test1	+$2.00
64	test23	+$7.00
5	test6	+$5.00
78	test22	+$10.00
102	test24	+$3.00
75	test10	+$4.00
104	test14	+$10.00
30	test15	+$8.00
24	test22	+$1.00
78	test28	+$9.00
107	test5	+$9.00
8	test10	+$5.00
82	test23	+$1.00
116	test14	+$3.00
93	test18	+$10.00
15	AdamGan	+$600.00
14	EricEwe	+$4,624.00
21	HaoJie	+$332.00
22	HaoJie	+$961.00
118	WooJeong	+$6,888.00
77	test21	+$13.00
59	test1	+$14.30
\.


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY project ("projectID", title, description, category, "startDate", "endDate", "targetAmount", "imageURL", username) FROM stdin;
1	Pixel 2.0 - The Arduino compatible smart display	The Pixel is an Arduino Zero compatible a smart display! It features a 32bit 48MHz Arm Cortex M0+ microcontroller with 32K of RAM, a 1.5 128x128 color OLED screen and a MicroSD slot. There are many things you can do with a board like this, like create wearables, attach sensors and display data with text or graphics, and even make simple retro video games!	Technology	2017-02-26	2017-06-26	+$5,000.00	C:\\temp\\Pixel.jpg	AdamGan
120	New project Title by test19	Sample description here!	Technology	2017-04-14	2017-08-14	+$1,149.00	C:\\temp\\proj120.jpg	test19
121	New project Title by test19	Sample description here!	Technology	2017-01-11	2017-05-11	+$4,857.00	C:\\temp\\proj121.jpg	test19
2	New project Title by test0	Sample description here!	Theather	2017-11-24	2018-03-24	+$8,471.00	C:\\temp\\proj2.jpg	test0
3	New project Title by test0	Sample description here!	Food	2017-08-27	2018-01-27	+$1,070.00	C:\\temp\\proj3.jpg	test0
4	New project Title by test0	Sample description here!	Publishing	2017-09-08	2018-01-08	+$4,827.00	C:\\temp\\proj4.jpg	test0
5	New project Title by test0	Sample description here!	Film and Video	2017-11-26	2018-03-26	+$8,830.00	C:\\temp\\proj5.jpg	test0
6	New project Title by test0	Sample description here!	Art	2017-03-22	2017-07-22	+$2,049.00	C:\\temp\\proj6.jpg	test0
7	New project Title by test0	Sample description here!	Design	2017-01-02	2017-05-02	+$9,176.00	C:\\temp\\proj7.jpg	test0
8	New project Title by test1	Sample description here!	Comic	2017-06-27	2017-10-27	+$9,301.00	C:\\temp\\proj8.jpg	test1
9	New project Title by test1	Sample description here!	Games	2017-07-22	2017-11-22	+$472.00	C:\\temp\\proj9.jpg	test1
10	New project Title by test1	Sample description here!	Publishing	2017-07-06	2017-11-06	+$2,273.00	C:\\temp\\proj10.jpg	test1
11	New project Title by test1	Sample description here!	Crafts	2017-04-20	2017-08-20	+$3,225.00	C:\\temp\\proj11.jpg	test1
12	New project Title by test1	Sample description here!	Fashion	2017-03-14	2017-07-14	+$9,867.00	C:\\temp\\proj12.jpg	test1
13	New project Title by test1	Sample description here!	Art	2017-08-25	2018-01-25	+$964.00	C:\\temp\\proj13.jpg	test1
14	New project Title by test2	Sample description here!	Fashion	2017-09-10	2018-01-10	+$4,625.00	C:\\temp\\proj14.jpg	test2
15	New project Title by test2	Sample description here!	Publishing	2017-08-03	2018-01-03	+$589.00	C:\\temp\\proj15.jpg	test2
16	New project Title by test2	Sample description here!	Fashion	2017-07-15	2017-11-15	+$2,509.00	C:\\temp\\proj16.jpg	test2
17	New project Title by test2	Sample description here!	Food	2017-01-11	2017-05-11	+$8,045.00	C:\\temp\\proj17.jpg	test2
18	New project Title by test2	Sample description here!	Fashion	2017-11-03	2018-03-03	+$5,574.00	C:\\temp\\proj18.jpg	test2
19	New project Title by test2	Sample description here!	Design	2017-07-20	2017-11-20	+$3,116.00	C:\\temp\\proj19.jpg	test2
20	New project Title by test3	Sample description here!	Food	2017-12-27	2018-04-27	+$943.00	C:\\temp\\proj20.jpg	test3
21	New project Title by test3	Sample description here!	Crafts	2017-09-26	2018-01-26	+$332.00	C:\\temp\\proj21.jpg	test3
22	New project Title by test3	Sample description here!	Film and Video	2017-06-03	2017-10-03	+$961.00	C:\\temp\\proj22.jpg	test3
23	New project Title by test3	Sample description here!	Comic	2017-03-14	2017-07-14	+$3,693.00	C:\\temp\\proj23.jpg	test3
24	New project Title by test3	Sample description here!	Fashion	2017-01-22	2017-05-22	+$7,684.00	C:\\temp\\proj24.jpg	test3
25	New project Title by test3	Sample description here!	Photography	2017-01-07	2017-05-07	+$4,800.00	C:\\temp\\proj25.jpg	test3
26	New project Title by test4	Sample description here!	Dance	2017-03-03	2017-07-03	+$3,024.00	C:\\temp\\proj26.jpg	test4
27	New project Title by test4	Sample description here!	Comic	2017-01-02	2017-05-02	+$5,244.00	C:\\temp\\proj27.jpg	test4
28	New project Title by test4	Sample description here!	Theather	2017-02-01	2017-06-01	+$7,595.00	C:\\temp\\proj28.jpg	test4
29	New project Title by test4	Sample description here!	Journalism	2017-02-12	2017-06-12	+$9,423.00	C:\\temp\\proj29.jpg	test4
30	New project Title by test4	Sample description here!	Crafts	2017-05-22	2017-09-22	+$3,079.00	C:\\temp\\proj30.jpg	test4
31	New project Title by test4	Sample description here!	Comic	2017-09-13	2018-01-13	+$7,397.00	C:\\temp\\proj31.jpg	test4
32	New project Title by test5	Sample description here!	Dance	2017-09-23	2018-01-23	+$6,896.00	C:\\temp\\proj32.jpg	test5
33	New project Title by test5	Sample description here!	Comic	2017-04-21	2017-08-21	+$4,592.00	C:\\temp\\proj33.jpg	test5
34	New project Title by test5	Sample description here!	Comic	2017-10-06	2018-02-06	+$4,010.00	C:\\temp\\proj34.jpg	test5
35	New project Title by test5	Sample description here!	Design	2017-03-24	2017-07-24	+$6,152.00	C:\\temp\\proj35.jpg	test5
36	New project Title by test5	Sample description here!	Film and Video	2017-11-16	2018-03-16	+$9,438.00	C:\\temp\\proj36.jpg	test5
37	New project Title by test5	Sample description here!	Dance	2017-03-27	2017-07-27	+$5,030.00	C:\\temp\\proj37.jpg	test5
38	New project Title by test6	Sample description here!	Film and Video	2017-09-24	2018-01-24	+$9,773.00	C:\\temp\\proj38.jpg	test6
39	New project Title by test6	Sample description here!	Theather	2017-06-05	2017-10-05	+$545.00	C:\\temp\\proj39.jpg	test6
40	New project Title by test6	Sample description here!	Journalism	2017-12-20	2018-04-20	+$1,822.00	C:\\temp\\proj40.jpg	test6
41	New project Title by test6	Sample description here!	Games	2017-07-19	2017-11-19	+$5,534.00	C:\\temp\\proj41.jpg	test6
42	New project Title by test6	Sample description here!	Film and Video	2017-07-05	2017-11-05	+$8,085.00	C:\\temp\\proj42.jpg	test6
43	New project Title by test6	Sample description here!	Design	2017-11-01	2018-03-01	+$7,305.00	C:\\temp\\proj43.jpg	test6
44	New project Title by test7	Sample description here!	Music	2017-11-08	2018-03-08	+$9,644.00	C:\\temp\\proj44.jpg	test7
45	New project Title by test7	Sample description here!	Food	2017-12-26	2018-04-26	+$8,860.00	C:\\temp\\proj45.jpg	test7
46	New project Title by test7	Sample description here!	Music	2017-05-24	2017-09-24	+$7,462.00	C:\\temp\\proj46.jpg	test7
47	New project Title by test7	Sample description here!	Fashion	2017-07-22	2017-11-22	+$5.00	C:\\temp\\proj47.jpg	test7
48	New project Title by test7	Sample description here!	Design	2017-06-18	2017-10-18	+$8,835.00	C:\\temp\\proj48.jpg	test7
49	New project Title by test7	Sample description here!	Fashion	2017-12-18	2018-04-18	+$2,511.00	C:\\temp\\proj49.jpg	test7
50	New project Title by test8	Sample description here!	Theather	2017-03-16	2017-07-16	+$561.00	C:\\temp\\proj50.jpg	test8
51	New project Title by test8	Sample description here!	Publishing	2017-04-22	2017-08-22	+$3,104.00	C:\\temp\\proj51.jpg	test8
52	New project Title by test8	Sample description here!	Games	2017-02-04	2017-06-04	+$8,602.00	C:\\temp\\proj52.jpg	test8
53	New project Title by test8	Sample description here!	Journalism	2017-06-01	2017-10-01	+$3,096.00	C:\\temp\\proj53.jpg	test8
54	New project Title by test8	Sample description here!	Music	2017-12-25	2018-04-25	+$2,663.00	C:\\temp\\proj54.jpg	test8
55	New project Title by test8	Sample description here!	Theather	2017-08-04	2018-01-04	+$3,651.00	C:\\temp\\proj55.jpg	test8
56	New project Title by test9	Sample description here!	Design	2017-12-02	2018-04-02	+$6,047.00	C:\\temp\\proj56.jpg	test9
57	New project Title by test9	Sample description here!	Technology	2017-07-28	2017-11-28	+$2,217.00	C:\\temp\\proj57.jpg	test9
58	New project Title by test9	Sample description here!	Photography	2017-07-01	2017-11-01	+$6,817.00	C:\\temp\\proj58.jpg	test9
59	New project Title by test9	Sample description here!	Dance	2017-07-20	2017-11-20	+$4,184.00	C:\\temp\\proj59.jpg	test9
60	New project Title by test9	Sample description here!	Comic	2017-09-12	2018-01-12	+$6,962.00	C:\\temp\\proj60.jpg	test9
61	New project Title by test9	Sample description here!	Design	2017-11-01	2018-03-01	+$6,643.00	C:\\temp\\proj61.jpg	test9
62	New project Title by test10	Sample description here!	Technology	2017-11-13	2018-03-13	+$5,889.00	C:\\temp\\proj62.jpg	test10
63	New project Title by test10	Sample description here!	Film and Video	2017-03-22	2017-07-22	+$9,622.00	C:\\temp\\proj63.jpg	test10
64	New project Title by test10	Sample description here!	Music	2017-02-16	2017-06-16	+$2,751.00	C:\\temp\\proj64.jpg	test10
65	New project Title by test10	Sample description here!	Games	2017-11-18	2018-03-18	+$7,677.00	C:\\temp\\proj65.jpg	test10
66	New project Title by test10	Sample description here!	Food	2017-10-23	2018-02-23	+$6,362.00	C:\\temp\\proj66.jpg	test10
67	New project Title by test10	Sample description here!	Food	2017-05-13	2017-09-13	+$8,586.00	C:\\temp\\proj67.jpg	test10
68	New project Title by test11	Sample description here!	Art	2017-03-10	2017-07-10	+$9,704.00	C:\\temp\\proj68.jpg	test11
69	New project Title by test11	Sample description here!	Crafts	2017-04-12	2017-08-12	+$308.00	C:\\temp\\proj69.jpg	test11
70	New project Title by test11	Sample description here!	Crafts	2017-09-09	2018-01-09	+$9,277.00	C:\\temp\\proj70.jpg	test11
71	New project Title by test11	Sample description here!	Music	2017-02-23	2017-06-23	+$5,697.00	C:\\temp\\proj71.jpg	test11
72	New project Title by test11	Sample description here!	Dance	2017-08-21	2018-01-21	+$4,182.00	C:\\temp\\proj72.jpg	test11
73	New project Title by test11	Sample description here!	Crafts	2017-06-28	2017-10-28	+$1,768.00	C:\\temp\\proj73.jpg	test11
74	New project Title by test12	Sample description here!	Games	2017-05-06	2017-09-06	+$233.00	C:\\temp\\proj74.jpg	test12
75	New project Title by test12	Sample description here!	Crafts	2017-03-22	2017-07-22	+$5,944.00	C:\\temp\\proj75.jpg	test12
76	New project Title by test12	Sample description here!	Theather	2017-02-07	2017-06-07	+$5,447.00	C:\\temp\\proj76.jpg	test12
77	New project Title by test12	Sample description here!	Food	2017-04-12	2017-08-12	+$1,656.00	C:\\temp\\proj77.jpg	test12
78	New project Title by test12	Sample description here!	Food	2017-02-10	2017-06-10	+$2,757.00	C:\\temp\\proj78.jpg	test12
79	New project Title by test12	Sample description here!	Crafts	2017-05-12	2017-09-12	+$5,187.00	C:\\temp\\proj79.jpg	test12
80	New project Title by test13	Sample description here!	Fashion	2017-12-25	2018-04-25	+$7,034.00	C:\\temp\\proj80.jpg	test13
81	New project Title by test13	Sample description here!	Film and Video	2017-05-07	2017-09-07	+$1,718.00	C:\\temp\\proj81.jpg	test13
82	New project Title by test13	Sample description here!	Technology	2017-04-18	2017-08-18	+$7,758.00	C:\\temp\\proj82.jpg	test13
83	New project Title by test13	Sample description here!	Fashion	2017-09-18	2018-01-18	+$2,285.00	C:\\temp\\proj83.jpg	test13
84	New project Title by test13	Sample description here!	Technology	2017-11-22	2018-03-22	+$7,658.00	C:\\temp\\proj84.jpg	test13
85	New project Title by test13	Sample description here!	Journalism	2017-03-26	2017-07-26	+$2,773.00	C:\\temp\\proj85.jpg	test13
86	New project Title by test14	Sample description here!	Comic	2017-08-25	2018-01-25	+$6,056.00	C:\\temp\\proj86.jpg	test14
87	New project Title by test14	Sample description here!	Fashion	2017-06-05	2017-10-05	+$8,178.00	C:\\temp\\proj87.jpg	test14
88	New project Title by test14	Sample description here!	Music	2017-03-07	2017-07-07	+$3,655.00	C:\\temp\\proj88.jpg	test14
89	New project Title by test14	Sample description here!	Fashion	2017-09-12	2018-01-12	+$9,077.00	C:\\temp\\proj89.jpg	test14
90	New project Title by test14	Sample description here!	Crafts	2017-08-13	2018-01-13	+$1,251.00	C:\\temp\\proj90.jpg	test14
91	New project Title by test14	Sample description here!	Crafts	2017-05-16	2017-09-16	+$5,566.00	C:\\temp\\proj91.jpg	test14
92	New project Title by test15	Sample description here!	Journalism	2017-11-19	2018-03-19	+$6,941.00	C:\\temp\\proj92.jpg	test15
93	New project Title by test15	Sample description here!	Music	2017-11-22	2018-03-22	+$6,697.00	C:\\temp\\proj93.jpg	test15
94	New project Title by test15	Sample description here!	Food	2017-11-21	2018-03-21	+$6,349.00	C:\\temp\\proj94.jpg	test15
95	New project Title by test15	Sample description here!	Publishing	2017-02-09	2017-06-09	+$9,521.00	C:\\temp\\proj95.jpg	test15
96	New project Title by test15	Sample description here!	Film and Video	2017-08-12	2018-01-12	+$5,357.00	C:\\temp\\proj96.jpg	test15
97	New project Title by test15	Sample description here!	Publishing	2017-09-16	2018-01-16	+$2,158.00	C:\\temp\\proj97.jpg	test15
98	New project Title by test16	Sample description here!	Art	2017-02-24	2017-06-24	+$9,699.00	C:\\temp\\proj98.jpg	test16
99	New project Title by test16	Sample description here!	Crafts	2017-09-03	2018-01-03	+$4,576.00	C:\\temp\\proj99.jpg	test16
100	New project Title by test16	Sample description here!	Music	2017-12-25	2018-04-25	+$6,102.00	C:\\temp\\proj100.jpg	test16
101	New project Title by test16	Sample description here!	Film and Video	2017-10-24	2018-02-24	+$745.00	C:\\temp\\proj101.jpg	test16
102	New project Title by test16	Sample description here!	Music	2017-12-01	2018-04-01	+$3,861.00	C:\\temp\\proj102.jpg	test16
103	New project Title by test16	Sample description here!	Journalism	2017-07-16	2017-11-16	+$7,412.00	C:\\temp\\proj103.jpg	test16
104	New project Title by test17	Sample description here!	Photography	2017-02-09	2017-06-09	+$7,769.00	C:\\temp\\proj104.jpg	test17
105	New project Title by test17	Sample description here!	Art	2017-12-04	2018-04-04	+$440.00	C:\\temp\\proj105.jpg	test17
106	New project Title by test17	Sample description here!	Journalism	2017-09-02	2018-01-02	+$4,980.00	C:\\temp\\proj106.jpg	test17
107	New project Title by test17	Sample description here!	Technology	2017-03-12	2017-07-12	+$6,298.00	C:\\temp\\proj107.jpg	test17
108	New project Title by test17	Sample description here!	Crafts	2017-04-10	2017-08-10	+$2,144.00	C:\\temp\\proj108.jpg	test17
109	New project Title by test17	Sample description here!	Film and Video	2017-02-27	2017-06-27	+$7,475.00	C:\\temp\\proj109.jpg	test17
110	New project Title by test18	Sample description here!	Games	2017-05-03	2017-09-03	+$224.00	C:\\temp\\proj110.jpg	test18
111	New project Title by test18	Sample description here!	Games	2017-02-21	2017-06-21	+$8,951.00	C:\\temp\\proj111.jpg	test18
112	New project Title by test18	Sample description here!	Photography	2017-03-25	2017-07-25	+$3,657.00	C:\\temp\\proj112.jpg	test18
113	New project Title by test18	Sample description here!	Publishing	2017-02-27	2017-06-27	+$2,909.00	C:\\temp\\proj113.jpg	test18
114	New project Title by test18	Sample description here!	Journalism	2017-06-09	2017-10-09	+$6,676.00	C:\\temp\\proj114.jpg	test18
115	New project Title by test18	Sample description here!	Publishing	2017-03-24	2017-07-24	+$9,365.00	C:\\temp\\proj115.jpg	test18
116	New project Title by test19	Sample description here!	Film and Video	2017-10-20	2018-02-20	+$1,894.00	C:\\temp\\proj116.jpg	test19
117	New project Title by test19	Sample description here!	Art	2017-06-26	2017-10-26	+$6,550.00	C:\\temp\\proj117.jpg	test19
118	New project Title by test19	Sample description here!	Food	2017-08-05	2018-01-05	+$6,888.00	C:\\temp\\proj118.jpg	test19
119	New project Title by test19	Sample description here!	Publishing	2017-12-15	2018-04-15	+$1,528.00	C:\\temp\\proj119.jpg	test19
\.


--
-- Name: project_projectID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"project_projectID_seq"', 121, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (username, password, accesslevel, email, name, "creditCard", nationality) FROM stdin;
admin123	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	admin@crowdfunding.com	admin	\N	\N
test0	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test0@hotmail.com	test0	\N	\N
test30	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test30@hotmail.com	test30	\N	\N
test20	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test20@hotmail.com	test20	\N	\N
test21	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test21@hotmail.com	test21	\N	\N
test22	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test22@hotmail.com	test22	\N	\N
test23	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test23@hotmail.com	test23	\N	\N
test24	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test24@hotmail.com	test24	\N	\N
test25	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test25@hotmail.com	test25	\N	\N
test26	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test26@hotmail.com	test26	\N	\N
test27	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test27@hotmail.com	test27	\N	\N
test28	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test28@hotmail.com	test28	\N	\N
test29	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test29@hotmail.com	test29	\N	\N
AdamGan	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	adamgan0527@gmail.com	Adam Gan	\N	Singaporean
test2	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test2@hotmail.com	test2	\N	Fijian
test3	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test3@hotmail.com	test3	\N	Marshallese
test4	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test4@hotmail.com	test4	\N	German
test5	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test5@hotmail.com	test5	\N	Motswana
test6	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test6@hotmail.com	test6	\N	Czech
test7	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test7@hotmail.com	test7	\N	Chilean
test8	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test8@hotmail.com	test8	\N	Salvadoran
test9	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test9@hotmail.com	test9	\N	Japanese
test10	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test10@hotmail.com	test10	\N	Qatari
test11	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test11@hotmail.com	test11	\N	Bosnian
test12	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test12@hotmail.com	test12	\N	Tunisian
test13	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test13@hotmail.com	test13	\N	Antiguans
test14	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test14@hotmail.com	test14	\N	Bruneian
test15	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test15@hotmail.com	test15	\N	Andorran
test16	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test16@hotmail.com	test16	\N	Eritrean
test17	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test17@hotmail.com	test17	\N	North Korean
test18	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test18@hotmail.com	test18	\N	Mexican
test19	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test19@hotmail.com	test19	\N	Cambodian
HaoJie	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	haojie@nus.edu.sg	Hao Jie	\N	Singaporean
EricEwe	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	Eric@nus.edu.sg	Eric Ewe	\N	Malaysian
Joleen	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	Joleen@nus.edu.sg	Joleen	\N	Singaporean
WooJeong	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	WooJeong@nus.edu.sg	Woo Jeong	\N	South Korean
testUser	932f3c1b56257ce8539ac269d7aab42550dacf8818d075f0bdf1990562aae3ef	f	testUser@hotmail.com	New Tester	\N	\N
test1	932f3c1b56257ce8539ac269d7aab42550dacf8818d075f0bdf1990562aae3ef	f	test1@hotmail.com	test1	\N	Gabonese
\.


--
-- Name: contribute contribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY contribute
    ADD CONSTRAINT contribute_pkey PRIMARY KEY ("projectID", username);


--
-- Name: project project_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY project
    ADD CONSTRAINT project_pkey PRIMARY KEY ("projectID");


--
-- Name: users user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT user_pkey PRIMARY KEY (username);


--
-- Name: contribute fk_contributeproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY contribute
    ADD CONSTRAINT fk_contributeproject FOREIGN KEY ("projectID") REFERENCES project("projectID") ON UPDATE CASCADE;


--
-- Name: contribute fk_contributeuser; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY contribute
    ADD CONSTRAINT fk_contributeuser FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE;


--
-- Name: project fk_userproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY project
    ADD CONSTRAINT fk_userproject FOREIGN KEY (username) REFERENCES users(username) ON UPDATE CASCADE;


--
-- PostgreSQL database dump complete
--

