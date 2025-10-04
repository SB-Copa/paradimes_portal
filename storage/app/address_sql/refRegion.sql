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
-- Name: refRegion; Type: TABLE; Schema: public; Owner: rebasedata
--

-- Drop table if it exists
DROP TABLE IF EXISTS public.refRegion;

-- Create table
CREATE TABLE public.refRegion (
    id SERIAL PRIMARY KEY,
    psgcCode VARCHAR(255),
    regDesc TEXT,
    regCode VARCHAR(255)
);


-- ALTER TABLE public.refRegion OWNER TO postgresql;

--
-- Data for Name: refRegion; Type: TABLE DATA; Schema: public; Owner: rebasedata
--

-- Insert data
INSERT INTO public.refRegion (id, psgcCode, regDesc, regCode) VALUES
(1, '010000000', 'REGION I (ILOCOS REGION)', '01'),
(2, '020000000', 'REGION II (CAGAYAN VALLEY)', '02'),
(3, '030000000', 'REGION III (CENTRAL LUZON)', '03'),
(4, '040000000', 'REGION IV-A (CALABARZON)', '04'),
(5, '170000000', 'REGION IV-B (MIMAROPA)', '17'),
(6, '050000000', 'REGION V (BICOL REGION)', '05'),
(7, '060000000', 'REGION VI (WESTERN VISAYAS)', '06'),
(8, '070000000', 'REGION VII (CENTRAL VISAYAS)', '07'),
(9, '080000000', 'REGION VIII (EASTERN VISAYAS)', '08'),
(10, '090000000', 'REGION IX (ZAMBOANGA PENINSULA)', '09'),
(11, '100000000', 'REGION X (NORTHERN MINDANAO)', '10'),
(12, '110000000', 'REGION XI (DAVAO REGION)', '11'),
(13, '120000000', 'REGION XII (SOCCSKSARGEN)', '12'),
(14, '130000000', 'NATIONAL CAPITAL REGION (NCR)', '13'),
(15, '140000000', 'CORDILLERA ADMINISTRATIVE REGION (CAR)', '14'),
(16, '150000000', 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)', '15'),
(17, '160000000', 'REGION XIII (Caraga)', '16');


--
-- PostgreSQL database dump complete
--

