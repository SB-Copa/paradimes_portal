--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.10
-- Dumped by pg_dump version 9.6.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
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
-- Name: _refregion; Type: TABLE; Schema: public; Owner: rebasedata
--

CREATE TABLE public._refregion (
    id smallint,
    "psgcCode" integer,
    "regDesc" character varying(43) DEFAULT NULL::character varying,
    "regCode" smallint
);


ALTER TABLE public._refregion OWNER TO rebasedata;

--
-- Data for Name: _refregion; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

COPY public._refregion (id, "psgcCode", "regDesc", "regCode") FROM stdin;
1	10000000	REGION I (ILOCOS REGION)	1
2	20000000	REGION II (CAGAYAN VALLEY)	2
3	30000000	REGION III (CENTRAL LUZON)	3
4	40000000	REGION IV-A (CALABARZON)	4
5	170000000	REGION IV-B (MIMAROPA)	17
6	50000000	REGION V (BICOL REGION)	5
7	60000000	REGION VI (WESTERN VISAYAS)	6
8	70000000	REGION VII (CENTRAL VISAYAS)	7
9	80000000	REGION VIII (EASTERN VISAYAS)	8
10	90000000	REGION IX (ZAMBOANGA PENINSULA)	9
11	100000000	REGION X (NORTHERN MINDANAO)	10
12	110000000	REGION XI (DAVAO REGION)	11
13	120000000	REGION XII (SOCCSKSARGEN)	12
14	130000000	NATIONAL CAPITAL REGION (NCR)	13
15	140000000	CORDILLERA ADMINISTRATIVE REGION (CAR)	14
16	150000000	AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)	15
17	160000000	REGION XIII (Caraga)	16
\.


--
-- PostgreSQL database dump complete
--

