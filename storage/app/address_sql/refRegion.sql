--
-- PostgreSQL database dump
--

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.0

-- Started on 2025-10-05 10:04:46 PST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 22147)
-- Name: refregion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.refregion (
    id bigint,
    "psgcCode" character varying(255),
    "regDesc" character varying(255),
    "regCode" character varying(255)
);


ALTER TABLE public.refregion OWNER TO postgres;

--
-- TOC entry 3423 (class 0 OID 22147)
-- Dependencies: 217
-- Data for Name: refregion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.refregion VALUES (1, '010000000', 'REGION I (ILOCOS REGION)', '01');
INSERT INTO public.refregion VALUES (2, '020000000', 'REGION II (CAGAYAN VALLEY)', '02');
INSERT INTO public.refregion VALUES (3, '030000000', 'REGION III (CENTRAL LUZON)', '03');
INSERT INTO public.refregion VALUES (4, '040000000', 'REGION IV-A (CALABARZON)', '04');
INSERT INTO public.refregion VALUES (5, '170000000', 'REGION IV-B (MIMAROPA)', '17');
INSERT INTO public.refregion VALUES (6, '050000000', 'REGION V (BICOL REGION)', '05');
INSERT INTO public.refregion VALUES (7, '060000000', 'REGION VI (WESTERN VISAYAS)', '06');
INSERT INTO public.refregion VALUES (8, '070000000', 'REGION VII (CENTRAL VISAYAS)', '07');
INSERT INTO public.refregion VALUES (9, '080000000', 'REGION VIII (EASTERN VISAYAS)', '08');
INSERT INTO public.refregion VALUES (10, '090000000', 'REGION IX (ZAMBOANGA PENINSULA)', '09');
INSERT INTO public.refregion VALUES (11, '100000000', 'REGION X (NORTHERN MINDANAO)', '10');
INSERT INTO public.refregion VALUES (12, '110000000', 'REGION XI (DAVAO REGION)', '11');
INSERT INTO public.refregion VALUES (13, '120000000', 'REGION XII (SOCCSKSARGEN)', '12');
INSERT INTO public.refregion VALUES (14, '130000000', 'NATIONAL CAPITAL REGION (NCR)', '13');
INSERT INTO public.refregion VALUES (15, '140000000', 'CORDILLERA ADMINISTRATIVE REGION (CAR)', '14');
INSERT INTO public.refregion VALUES (16, '150000000', 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)', '15');
INSERT INTO public.refregion VALUES (17, '160000000', 'REGION XIII (Caraga)', '16');


-- Completed on 2025-10-05 10:05:01 PST

--
-- PostgreSQL database dump complete
--

