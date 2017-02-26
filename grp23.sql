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

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: Contribute; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Contribute" (
    "projectID" integer NOT NULL,
    username character varying(254) NOT NULL,
    amount money NOT NULL
);


ALTER TABLE "Contribute" OWNER TO postgres;

--
-- Name: COLUMN "Contribute"."projectID"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Contribute"."projectID" IS 'foreign key constraint';


--
-- Name: COLUMN "Contribute".username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Contribute".username IS 'foreign key constraint';


--
-- Name: Project; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Project" (
    "projectID" integer NOT NULL,
    title character varying(254) NOT NULL,
    description character varying(508),
    category character varying(254),
    "startDate" date NOT NULL,
    "endDate" date,
    "targetAmount" money NOT NULL,
    "imageURL" character varying(254),
    username character varying(254) NOT NULL
);


ALTER TABLE "Project" OWNER TO postgres;

--
-- Name: COLUMN "Project"."projectID"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Project"."projectID" IS '4-byte signed integer that is auto-incrementing';


--
-- Name: COLUMN "Project".category; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Project".category IS '##constraint check if belong to { pre-defined categories }';


--
-- Name: COLUMN "Project"."endDate"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Project"."endDate" IS '##constraint check if endDate > startDate';


--
-- Name: COLUMN "Project"."imageURL"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Project"."imageURL" IS '##during retrieval if null use default image?';


--
-- Name: COLUMN "Project".username; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "Project".username IS 'foreign key constraint';


--
-- Name: Project_projectID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Project_projectID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Project_projectID_seq" OWNER TO postgres;

--
-- Name: Project_projectID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Project_projectID_seq" OWNED BY "Project"."projectID";


--
-- Name: User; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "User" (
    username character varying(24) NOT NULL,
    password character(64) NOT NULL,
    accesslevel boolean DEFAULT false NOT NULL,
    email character varying(80) NOT NULL,
    name character varying(254) NOT NULL
);


ALTER TABLE "User" OWNER TO postgres;

--
-- Name: TABLE "User"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE "User" IS 'username, password, accesslevel';


--
-- Name: COLUMN "User".password; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "User".password IS 'hashed password';


--
-- Name: COLUMN "User".accesslevel; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN "User".accesslevel IS 'admin(true) or user(false)';


--
-- Name: Project projectID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Project" ALTER COLUMN "projectID" SET DEFAULT nextval('"Project_projectID_seq"'::regclass);


--
-- Data for Name: Contribute; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Contribute" ("projectID", username, amount) FROM stdin;
77	test21	+$6.00
1	test22	+$4.00
17	test22	+$7.00
59	test1	+$10.00
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
\.


--
-- Data for Name: Project; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Project" ("projectID", title, description, category, "startDate", "endDate", "targetAmount", "imageURL", username) FROM stdin;
1	Pixel 2.0 - The Arduino compatible smart display	The Pixel is an Arduino Zero compatible a smart display! It features a 32bit 48MHz Arm Cortex M0+ microcontroller with 32K of RAM, a 1.5 128x128 color OLED screen and a MicroSD slot. There are many things you can do with a board like this, like create wearables, attach sensors and display data with text or graphics, and even make simple retro video games!	technology	2017-02-26	2017-06-26	+$5,000.00	C:\\temp\\Pixel.jpg	AdamGan
2	New Project Title by test0	Sample description here!	technology	2017-11-24	2018-03-24	+$8,471.00	C:\\temp\\proj2.jpg	test0
3	New Project Title by test0	Sample description here!	technology	2017-08-27	2017-01-27	+$1,070.00	C:\\temp\\proj3.jpg	test0
4	New Project Title by test0	Sample description here!	technology	2017-09-08	2018-01-08	+$4,827.00	C:\\temp\\proj4.jpg	test0
5	New Project Title by test0	Sample description here!	technology	2017-11-26	2018-03-26	+$8,830.00	C:\\temp\\proj5.jpg	test0
6	New Project Title by test0	Sample description here!	technology	2017-03-22	2017-07-22	+$2,049.00	C:\\temp\\proj6.jpg	test0
7	New Project Title by test0	Sample description here!	technology	2017-01-02	2017-05-02	+$9,176.00	C:\\temp\\proj7.jpg	test0
8	New Project Title by test1	Sample description here!	technology	2017-06-27	2017-10-27	+$9,301.00	C:\\temp\\proj8.jpg	test1
9	New Project Title by test1	Sample description here!	technology	2017-07-22	2017-11-22	+$472.00	C:\\temp\\proj9.jpg	test1
10	New Project Title by test1	Sample description here!	technology	2017-07-06	2017-11-06	+$2,273.00	C:\\temp\\proj10.jpg	test1
11	New Project Title by test1	Sample description here!	technology	2017-04-20	2017-08-20	+$3,225.00	C:\\temp\\proj11.jpg	test1
12	New Project Title by test1	Sample description here!	technology	2017-03-14	2017-07-14	+$9,867.00	C:\\temp\\proj12.jpg	test1
13	New Project Title by test1	Sample description here!	technology	2017-08-25	2017-01-25	+$964.00	C:\\temp\\proj13.jpg	test1
14	New Project Title by test2	Sample description here!	technology	2017-09-10	2018-01-10	+$4,625.00	C:\\temp\\proj14.jpg	test2
15	New Project Title by test2	Sample description here!	technology	2017-08-03	2017-01-03	+$589.00	C:\\temp\\proj15.jpg	test2
16	New Project Title by test2	Sample description here!	technology	2017-07-15	2017-11-15	+$2,509.00	C:\\temp\\proj16.jpg	test2
17	New Project Title by test2	Sample description here!	technology	2017-01-11	2017-05-11	+$8,045.00	C:\\temp\\proj17.jpg	test2
18	New Project Title by test2	Sample description here!	technology	2017-11-03	2018-03-03	+$5,574.00	C:\\temp\\proj18.jpg	test2
19	New Project Title by test2	Sample description here!	technology	2017-07-20	2017-11-20	+$3,116.00	C:\\temp\\proj19.jpg	test2
20	New Project Title by test3	Sample description here!	technology	2017-12-27	2018-04-27	+$943.00	C:\\temp\\proj20.jpg	test3
21	New Project Title by test3	Sample description here!	technology	2017-09-26	2018-01-26	+$332.00	C:\\temp\\proj21.jpg	test3
22	New Project Title by test3	Sample description here!	technology	2017-06-03	2017-10-03	+$961.00	C:\\temp\\proj22.jpg	test3
23	New Project Title by test3	Sample description here!	technology	2017-03-14	2017-07-14	+$3,693.00	C:\\temp\\proj23.jpg	test3
24	New Project Title by test3	Sample description here!	technology	2017-01-22	2017-05-22	+$7,684.00	C:\\temp\\proj24.jpg	test3
25	New Project Title by test3	Sample description here!	technology	2017-01-07	2017-05-07	+$4,800.00	C:\\temp\\proj25.jpg	test3
26	New Project Title by test4	Sample description here!	technology	2017-03-03	2017-07-03	+$3,024.00	C:\\temp\\proj26.jpg	test4
27	New Project Title by test4	Sample description here!	technology	2017-01-02	2017-05-02	+$5,244.00	C:\\temp\\proj27.jpg	test4
28	New Project Title by test4	Sample description here!	technology	2017-02-01	2017-06-01	+$7,595.00	C:\\temp\\proj28.jpg	test4
29	New Project Title by test4	Sample description here!	technology	2017-02-12	2017-06-12	+$9,423.00	C:\\temp\\proj29.jpg	test4
30	New Project Title by test4	Sample description here!	technology	2017-05-22	2017-09-22	+$3,079.00	C:\\temp\\proj30.jpg	test4
31	New Project Title by test4	Sample description here!	technology	2017-09-13	2018-01-13	+$7,397.00	C:\\temp\\proj31.jpg	test4
32	New Project Title by test5	Sample description here!	technology	2017-09-23	2018-01-23	+$6,896.00	C:\\temp\\proj32.jpg	test5
33	New Project Title by test5	Sample description here!	technology	2017-04-21	2017-08-21	+$4,592.00	C:\\temp\\proj33.jpg	test5
34	New Project Title by test5	Sample description here!	technology	2017-10-06	2018-02-06	+$4,010.00	C:\\temp\\proj34.jpg	test5
35	New Project Title by test5	Sample description here!	technology	2017-03-24	2017-07-24	+$6,152.00	C:\\temp\\proj35.jpg	test5
36	New Project Title by test5	Sample description here!	technology	2017-11-16	2018-03-16	+$9,438.00	C:\\temp\\proj36.jpg	test5
37	New Project Title by test5	Sample description here!	technology	2017-03-27	2017-07-27	+$5,030.00	C:\\temp\\proj37.jpg	test5
38	New Project Title by test6	Sample description here!	technology	2017-09-24	2018-01-24	+$9,773.00	C:\\temp\\proj38.jpg	test6
39	New Project Title by test6	Sample description here!	technology	2017-06-05	2017-10-05	+$545.00	C:\\temp\\proj39.jpg	test6
40	New Project Title by test6	Sample description here!	technology	2017-12-20	2018-04-20	+$1,822.00	C:\\temp\\proj40.jpg	test6
41	New Project Title by test6	Sample description here!	technology	2017-07-19	2017-11-19	+$5,534.00	C:\\temp\\proj41.jpg	test6
42	New Project Title by test6	Sample description here!	technology	2017-07-05	2017-11-05	+$8,085.00	C:\\temp\\proj42.jpg	test6
43	New Project Title by test6	Sample description here!	technology	2017-11-01	2018-03-01	+$7,305.00	C:\\temp\\proj43.jpg	test6
44	New Project Title by test7	Sample description here!	technology	2017-11-08	2018-03-08	+$9,644.00	C:\\temp\\proj44.jpg	test7
45	New Project Title by test7	Sample description here!	technology	2017-12-26	2018-04-26	+$8,860.00	C:\\temp\\proj45.jpg	test7
46	New Project Title by test7	Sample description here!	technology	2017-05-24	2017-09-24	+$7,462.00	C:\\temp\\proj46.jpg	test7
47	New Project Title by test7	Sample description here!	technology	2017-07-22	2017-11-22	+$5.00	C:\\temp\\proj47.jpg	test7
48	New Project Title by test7	Sample description here!	technology	2017-06-18	2017-10-18	+$8,835.00	C:\\temp\\proj48.jpg	test7
49	New Project Title by test7	Sample description here!	technology	2017-12-18	2018-04-18	+$2,511.00	C:\\temp\\proj49.jpg	test7
50	New Project Title by test8	Sample description here!	technology	2017-03-16	2017-07-16	+$561.00	C:\\temp\\proj50.jpg	test8
51	New Project Title by test8	Sample description here!	technology	2017-04-22	2017-08-22	+$3,104.00	C:\\temp\\proj51.jpg	test8
52	New Project Title by test8	Sample description here!	technology	2017-02-04	2017-06-04	+$8,602.00	C:\\temp\\proj52.jpg	test8
53	New Project Title by test8	Sample description here!	technology	2017-06-01	2017-10-01	+$3,096.00	C:\\temp\\proj53.jpg	test8
54	New Project Title by test8	Sample description here!	technology	2017-12-25	2018-04-25	+$2,663.00	C:\\temp\\proj54.jpg	test8
55	New Project Title by test8	Sample description here!	technology	2017-08-04	2017-01-04	+$3,651.00	C:\\temp\\proj55.jpg	test8
56	New Project Title by test9	Sample description here!	technology	2017-12-02	2018-04-02	+$6,047.00	C:\\temp\\proj56.jpg	test9
57	New Project Title by test9	Sample description here!	technology	2017-07-28	2017-11-28	+$2,217.00	C:\\temp\\proj57.jpg	test9
58	New Project Title by test9	Sample description here!	technology	2017-07-01	2017-11-01	+$6,817.00	C:\\temp\\proj58.jpg	test9
59	New Project Title by test9	Sample description here!	technology	2017-07-20	2017-11-20	+$4,184.00	C:\\temp\\proj59.jpg	test9
60	New Project Title by test9	Sample description here!	technology	2017-09-12	2018-01-12	+$6,962.00	C:\\temp\\proj60.jpg	test9
61	New Project Title by test9	Sample description here!	technology	2017-11-01	2018-03-01	+$6,643.00	C:\\temp\\proj61.jpg	test9
62	New Project Title by test10	Sample description here!	technology	2017-11-13	2018-03-13	+$5,889.00	C:\\temp\\proj62.jpg	test10
63	New Project Title by test10	Sample description here!	technology	2017-03-22	2017-07-22	+$9,622.00	C:\\temp\\proj63.jpg	test10
64	New Project Title by test10	Sample description here!	technology	2017-02-16	2017-06-16	+$2,751.00	C:\\temp\\proj64.jpg	test10
65	New Project Title by test10	Sample description here!	technology	2017-11-18	2018-03-18	+$7,677.00	C:\\temp\\proj65.jpg	test10
66	New Project Title by test10	Sample description here!	technology	2017-10-23	2018-02-23	+$6,362.00	C:\\temp\\proj66.jpg	test10
67	New Project Title by test10	Sample description here!	technology	2017-05-13	2017-09-13	+$8,586.00	C:\\temp\\proj67.jpg	test10
68	New Project Title by test11	Sample description here!	technology	2017-03-10	2017-07-10	+$9,704.00	C:\\temp\\proj68.jpg	test11
69	New Project Title by test11	Sample description here!	technology	2017-04-12	2017-08-12	+$308.00	C:\\temp\\proj69.jpg	test11
70	New Project Title by test11	Sample description here!	technology	2017-09-09	2018-01-09	+$9,277.00	C:\\temp\\proj70.jpg	test11
71	New Project Title by test11	Sample description here!	technology	2017-02-23	2017-06-23	+$5,697.00	C:\\temp\\proj71.jpg	test11
72	New Project Title by test11	Sample description here!	technology	2017-08-21	2017-01-21	+$4,182.00	C:\\temp\\proj72.jpg	test11
73	New Project Title by test11	Sample description here!	technology	2017-06-28	2017-10-28	+$1,768.00	C:\\temp\\proj73.jpg	test11
74	New Project Title by test12	Sample description here!	technology	2017-05-06	2017-09-06	+$233.00	C:\\temp\\proj74.jpg	test12
75	New Project Title by test12	Sample description here!	technology	2017-03-22	2017-07-22	+$5,944.00	C:\\temp\\proj75.jpg	test12
76	New Project Title by test12	Sample description here!	technology	2017-02-07	2017-06-07	+$5,447.00	C:\\temp\\proj76.jpg	test12
77	New Project Title by test12	Sample description here!	technology	2017-04-12	2017-08-12	+$1,656.00	C:\\temp\\proj77.jpg	test12
78	New Project Title by test12	Sample description here!	technology	2017-02-10	2017-06-10	+$2,757.00	C:\\temp\\proj78.jpg	test12
79	New Project Title by test12	Sample description here!	technology	2017-05-12	2017-09-12	+$5,187.00	C:\\temp\\proj79.jpg	test12
80	New Project Title by test13	Sample description here!	technology	2017-12-25	2018-04-25	+$7,034.00	C:\\temp\\proj80.jpg	test13
81	New Project Title by test13	Sample description here!	technology	2017-05-07	2017-09-07	+$1,718.00	C:\\temp\\proj81.jpg	test13
82	New Project Title by test13	Sample description here!	technology	2017-04-18	2017-08-18	+$7,758.00	C:\\temp\\proj82.jpg	test13
83	New Project Title by test13	Sample description here!	technology	2017-09-18	2018-01-18	+$2,285.00	C:\\temp\\proj83.jpg	test13
84	New Project Title by test13	Sample description here!	technology	2017-11-22	2018-03-22	+$7,658.00	C:\\temp\\proj84.jpg	test13
85	New Project Title by test13	Sample description here!	technology	2017-03-26	2017-07-26	+$2,773.00	C:\\temp\\proj85.jpg	test13
86	New Project Title by test14	Sample description here!	technology	2017-08-25	2017-01-25	+$6,056.00	C:\\temp\\proj86.jpg	test14
87	New Project Title by test14	Sample description here!	technology	2017-06-05	2017-10-05	+$8,178.00	C:\\temp\\proj87.jpg	test14
88	New Project Title by test14	Sample description here!	technology	2017-03-07	2017-07-07	+$3,655.00	C:\\temp\\proj88.jpg	test14
89	New Project Title by test14	Sample description here!	technology	2017-09-12	2018-01-12	+$9,077.00	C:\\temp\\proj89.jpg	test14
90	New Project Title by test14	Sample description here!	technology	2017-08-13	2017-01-13	+$1,251.00	C:\\temp\\proj90.jpg	test14
91	New Project Title by test14	Sample description here!	technology	2017-05-16	2017-09-16	+$5,566.00	C:\\temp\\proj91.jpg	test14
92	New Project Title by test15	Sample description here!	technology	2017-11-19	2018-03-19	+$6,941.00	C:\\temp\\proj92.jpg	test15
93	New Project Title by test15	Sample description here!	technology	2017-11-22	2018-03-22	+$6,697.00	C:\\temp\\proj93.jpg	test15
94	New Project Title by test15	Sample description here!	technology	2017-11-21	2018-03-21	+$6,349.00	C:\\temp\\proj94.jpg	test15
95	New Project Title by test15	Sample description here!	technology	2017-02-09	2017-06-09	+$9,521.00	C:\\temp\\proj95.jpg	test15
96	New Project Title by test15	Sample description here!	technology	2017-08-12	2017-01-12	+$5,357.00	C:\\temp\\proj96.jpg	test15
97	New Project Title by test15	Sample description here!	technology	2017-09-16	2018-01-16	+$2,158.00	C:\\temp\\proj97.jpg	test15
98	New Project Title by test16	Sample description here!	technology	2017-02-24	2017-06-24	+$9,699.00	C:\\temp\\proj98.jpg	test16
99	New Project Title by test16	Sample description here!	technology	2017-09-03	2018-01-03	+$4,576.00	C:\\temp\\proj99.jpg	test16
100	New Project Title by test16	Sample description here!	technology	2017-12-25	2018-04-25	+$6,102.00	C:\\temp\\proj100.jpg	test16
101	New Project Title by test16	Sample description here!	technology	2017-10-24	2018-02-24	+$745.00	C:\\temp\\proj101.jpg	test16
102	New Project Title by test16	Sample description here!	technology	2017-12-01	2018-04-01	+$3,861.00	C:\\temp\\proj102.jpg	test16
103	New Project Title by test16	Sample description here!	technology	2017-07-16	2017-11-16	+$7,412.00	C:\\temp\\proj103.jpg	test16
104	New Project Title by test17	Sample description here!	technology	2017-02-09	2017-06-09	+$7,769.00	C:\\temp\\proj104.jpg	test17
105	New Project Title by test17	Sample description here!	technology	2017-12-04	2018-04-04	+$440.00	C:\\temp\\proj105.jpg	test17
106	New Project Title by test17	Sample description here!	technology	2017-09-02	2018-01-02	+$4,980.00	C:\\temp\\proj106.jpg	test17
107	New Project Title by test17	Sample description here!	technology	2017-03-12	2017-07-12	+$6,298.00	C:\\temp\\proj107.jpg	test17
108	New Project Title by test17	Sample description here!	technology	2017-04-10	2017-08-10	+$2,144.00	C:\\temp\\proj108.jpg	test17
109	New Project Title by test17	Sample description here!	technology	2017-02-27	2017-06-27	+$7,475.00	C:\\temp\\proj109.jpg	test17
110	New Project Title by test18	Sample description here!	technology	2017-05-03	2017-09-03	+$224.00	C:\\temp\\proj110.jpg	test18
111	New Project Title by test18	Sample description here!	technology	2017-02-21	2017-06-21	+$8,951.00	C:\\temp\\proj111.jpg	test18
112	New Project Title by test18	Sample description here!	technology	2017-03-25	2017-07-25	+$3,657.00	C:\\temp\\proj112.jpg	test18
113	New Project Title by test18	Sample description here!	technology	2017-02-27	2017-06-27	+$2,909.00	C:\\temp\\proj113.jpg	test18
114	New Project Title by test18	Sample description here!	technology	2017-06-09	2017-10-09	+$6,676.00	C:\\temp\\proj114.jpg	test18
115	New Project Title by test18	Sample description here!	technology	2017-03-24	2017-07-24	+$9,365.00	C:\\temp\\proj115.jpg	test18
116	New Project Title by test19	Sample description here!	technology	2017-10-20	2018-02-20	+$1,894.00	C:\\temp\\proj116.jpg	test19
117	New Project Title by test19	Sample description here!	technology	2017-06-26	2017-10-26	+$6,550.00	C:\\temp\\proj117.jpg	test19
118	New Project Title by test19	Sample description here!	technology	2017-08-05	2017-01-05	+$6,888.00	C:\\temp\\proj118.jpg	test19
119	New Project Title by test19	Sample description here!	technology	2017-12-15	2018-04-15	+$1,528.00	C:\\temp\\proj119.jpg	test19
120	New Project Title by test19	Sample description here!	technology	2017-04-14	2017-08-14	+$1,149.00	C:\\temp\\proj120.jpg	test19
121	New Project Title by test19	Sample description here!	technology	2017-01-11	2017-05-11	+$4,857.00	C:\\temp\\proj121.jpg	test19
\.


--
-- Name: Project_projectID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Project_projectID_seq"', 121, true);


--
-- Data for Name: User; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "User" (username, password, accesslevel, email, name) FROM stdin;
AdamGan	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	adamgan0527@gmail.com	Adam Gan
HaoJie	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	haojie@nus.edu.sg	Hao Jie
EricEwe	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	Eric@nus.edu.sg	Eric Ewe
Joleen	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	Joleen@nus.edu.sg	Joleen
WooJeong	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	WooJeong@nus.edu.sg	Woo Jeong
admin123	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	t	admin@crowdfunding.com	admin
test0	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test0@hotmail.com	test0
test30	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test30@hotmail.com	test30
test1	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test1@hotmail.com	test1
test2	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test2@hotmail.com	test2
test3	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test3@hotmail.com	test3
test4	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test4@hotmail.com	test4
test5	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test5@hotmail.com	test5
test6	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test6@hotmail.com	test6
test7	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test7@hotmail.com	test7
test8	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test8@hotmail.com	test8
test9	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test9@hotmail.com	test9
test10	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test10@hotmail.com	test10
test11	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test11@hotmail.com	test11
test12	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test12@hotmail.com	test12
test13	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test13@hotmail.com	test13
test14	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test14@hotmail.com	test14
test15	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test15@hotmail.com	test15
test16	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test16@hotmail.com	test16
test17	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test17@hotmail.com	test17
test18	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test18@hotmail.com	test18
test19	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test19@hotmail.com	test19
test20	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test20@hotmail.com	test20
test21	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test21@hotmail.com	test21
test22	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test22@hotmail.com	test22
test23	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test23@hotmail.com	test23
test24	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test24@hotmail.com	test24
test25	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test25@hotmail.com	test25
test26	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test26@hotmail.com	test26
test27	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test27@hotmail.com	test27
test28	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test28@hotmail.com	test28
test29	8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92	f	test29@hotmail.com	test29
\.


--
-- Name: Contribute Contribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Contribute"
    ADD CONSTRAINT "Contribute_pkey" PRIMARY KEY ("projectID", username);


--
-- Name: Project Project_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Project"
    ADD CONSTRAINT "Project_pkey" PRIMARY KEY ("projectID");


--
-- Name: User user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "User"
    ADD CONSTRAINT user_pkey PRIMARY KEY (username);


--
-- Name: Contribute fk_contributeProject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Contribute"
    ADD CONSTRAINT "fk_contributeProject" FOREIGN KEY ("projectID") REFERENCES "Project"("projectID");


--
-- Name: Contribute fk_contributeuser; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Contribute"
    ADD CONSTRAINT fk_contributeuser FOREIGN KEY (username) REFERENCES "User"(username);


--
-- Name: Project fk_userproject; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Project"
    ADD CONSTRAINT fk_userproject FOREIGN KEY (username) REFERENCES "User"(username);


--
-- PostgreSQL database dump complete
--

