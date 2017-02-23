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
    "currentAmount" money,
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
\.


--
-- Data for Name: Project; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Project" ("projectID", title, description, category, "startDate", "endDate", "targetAmount", "currentAmount", "imageURL", username) FROM stdin;
\.


--
-- Name: Project_projectID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Project_projectID_seq"', 1, false);


--
-- Data for Name: User; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "User" (username, password, accesslevel, email, name) FROM stdin;
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

