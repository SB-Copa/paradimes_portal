--
-- PostgreSQL database dump
--

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.0

-- Started on 2025-10-05 10:05:57 PST

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
-- TOC entry 218 (class 1259 OID 22150)
-- Name: refprovince; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.refprovince (
    id bigint,
    "psgcCode" character varying(255),
    "provDesc" character varying(255),
    "regCode" character varying(255),
    "provCode" character varying(255)
);


ALTER TABLE public.refprovince OWNER TO postgres;

--
-- TOC entry 3423 (class 0 OID 22150)
-- Dependencies: 218
-- Data for Name: refprovince; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.refprovince VALUES (1, '12800000', 'ILOCOS NORTE', '1', '128');
INSERT INTO public.refprovince VALUES (2, '12900000', 'ILOCOS SUR', '1', '129');
INSERT INTO public.refprovince VALUES (3, '13300000', 'LA UNION', '1', '133');
INSERT INTO public.refprovince VALUES (4, '15500000', 'PANGASINAN', '1', '155');
INSERT INTO public.refprovince VALUES (5, '20900000', 'BATANES', '2', '209');
INSERT INTO public.refprovince VALUES (6, '21500000', 'CAGAYAN', '2', '215');
INSERT INTO public.refprovince VALUES (7, '23100000', 'ISABELA', '2', '231');
INSERT INTO public.refprovince VALUES (8, '25000000', 'NUEVA VIZCAYA', '2', '250');
INSERT INTO public.refprovince VALUES (9, '25700000', 'QUIRINO', '2', '257');
INSERT INTO public.refprovince VALUES (10, '30800000', 'BATAAN', '3', '308');
INSERT INTO public.refprovince VALUES (11, '31400000', 'BULACAN', '3', '314');
INSERT INTO public.refprovince VALUES (12, '34900000', 'NUEVA ECIJA', '3', '349');
INSERT INTO public.refprovince VALUES (13, '35400000', 'PAMPANGA', '3', '354');
INSERT INTO public.refprovince VALUES (14, '36900000', 'TARLAC', '3', '369');
INSERT INTO public.refprovince VALUES (15, '37100000', 'ZAMBALES', '3', '371');
INSERT INTO public.refprovince VALUES (16, '37700000', 'AURORA', '3', '377');
INSERT INTO public.refprovince VALUES (17, '41000000', 'BATANGAS', '4', '410');
INSERT INTO public.refprovince VALUES (18, '42100000', 'CAVITE', '4', '421');
INSERT INTO public.refprovince VALUES (19, '43400000', 'LAGUNA', '4', '434');
INSERT INTO public.refprovince VALUES (20, '45600000', 'QUEZON', '4', '456');
INSERT INTO public.refprovince VALUES (21, '45800000', 'RIZAL', '4', '458');
INSERT INTO public.refprovince VALUES (22, '174000000', 'MARINDUQUE', '17', '1740');
INSERT INTO public.refprovince VALUES (23, '175100000', 'OCCIDENTAL MINDORO', '17', '1751');
INSERT INTO public.refprovince VALUES (24, '175200000', 'ORIENTAL MINDORO', '17', '1752');
INSERT INTO public.refprovince VALUES (25, '175300000', 'PALAWAN', '17', '1753');
INSERT INTO public.refprovince VALUES (26, '175900000', 'ROMBLON', '17', '1759');
INSERT INTO public.refprovince VALUES (27, '50500000', 'ALBAY', '5', '505');
INSERT INTO public.refprovince VALUES (28, '51600000', 'CAMARINES NORTE', '5', '516');
INSERT INTO public.refprovince VALUES (29, '51700000', 'CAMARINES SUR', '5', '517');
INSERT INTO public.refprovince VALUES (30, '52000000', 'CATANDUANES', '5', '520');
INSERT INTO public.refprovince VALUES (31, '54100000', 'MASBATE', '5', '541');
INSERT INTO public.refprovince VALUES (32, '56200000', 'SORSOGON', '5', '562');
INSERT INTO public.refprovince VALUES (33, '60400000', 'AKLAN', '6', '604');
INSERT INTO public.refprovince VALUES (34, '60600000', 'ANTIQUE', '6', '606');
INSERT INTO public.refprovince VALUES (35, '61900000', 'CAPIZ', '6', '619');
INSERT INTO public.refprovince VALUES (36, '63000000', 'ILOILO', '6', '630');
INSERT INTO public.refprovince VALUES (37, '64500000', 'NEGROS OCCIDENTAL', '6', '645');
INSERT INTO public.refprovince VALUES (38, '67900000', 'GUIMARAS', '6', '679');
INSERT INTO public.refprovince VALUES (39, '71200000', 'BOHOL', '7', '712');
INSERT INTO public.refprovince VALUES (40, '72200000', 'CEBU', '7', '722');
INSERT INTO public.refprovince VALUES (41, '74600000', 'NEGROS ORIENTAL', '7', '746');
INSERT INTO public.refprovince VALUES (42, '76100000', 'SIQUIJOR', '7', '761');
INSERT INTO public.refprovince VALUES (43, '82600000', 'EASTERN SAMAR', '8', '826');
INSERT INTO public.refprovince VALUES (44, '83700000', 'LEYTE', '8', '837');
INSERT INTO public.refprovince VALUES (45, '84800000', 'NORTHERN SAMAR', '8', '848');
INSERT INTO public.refprovince VALUES (46, '86000000', 'SAMAR (WESTERN SAMAR)', '8', '860');
INSERT INTO public.refprovince VALUES (47, '86400000', 'SOUTHERN LEYTE', '8', '864');
INSERT INTO public.refprovince VALUES (48, '87800000', 'BILIRAN', '8', '878');
INSERT INTO public.refprovince VALUES (49, '97200000', 'ZAMBOANGA DEL NORTE', '9', '972');
INSERT INTO public.refprovince VALUES (50, '97300000', 'ZAMBOANGA DEL SUR', '9', '973');
INSERT INTO public.refprovince VALUES (51, '98300000', 'ZAMBOANGA SIBUGAY', '9', '983');
INSERT INTO public.refprovince VALUES (52, '99700000', 'CITY OF ISABELA', '9', '997');
INSERT INTO public.refprovince VALUES (53, '101300000', 'BUKIDNON', '10', '1013');
INSERT INTO public.refprovince VALUES (54, '101800000', 'CAMIGUIN', '10', '1018');
INSERT INTO public.refprovince VALUES (55, '103500000', 'LANAO DEL NORTE', '10', '1035');
INSERT INTO public.refprovince VALUES (56, '104200000', 'MISAMIS OCCIDENTAL', '10', '1042');
INSERT INTO public.refprovince VALUES (57, '104300000', 'MISAMIS ORIENTAL', '10', '1043');
INSERT INTO public.refprovince VALUES (58, '112300000', 'DAVAO DEL NORTE', '11', '1123');
INSERT INTO public.refprovince VALUES (59, '112400000', 'DAVAO DEL SUR', '11', '1124');
INSERT INTO public.refprovince VALUES (60, '112500000', 'DAVAO ORIENTAL', '11', '1125');
INSERT INTO public.refprovince VALUES (61, '118200000', 'COMPOSTELA VALLEY', '11', '1182');
INSERT INTO public.refprovince VALUES (62, '118600000', 'DAVAO OCCIDENTAL', '11', '1186');
INSERT INTO public.refprovince VALUES (63, '124700000', 'COTABATO (NORTH COTABATO)', '12', '1247');
INSERT INTO public.refprovince VALUES (64, '126300000', 'SOUTH COTABATO', '12', '1263');
INSERT INTO public.refprovince VALUES (65, '126500000', 'SULTAN KUDARAT', '12', '1265');
INSERT INTO public.refprovince VALUES (66, '128000000', 'SARANGANI', '12', '1280');
INSERT INTO public.refprovince VALUES (67, '129800000', 'COTABATO CITY', '12', '1298');
INSERT INTO public.refprovince VALUES (68, '133900000', 'NCR, CITY OF MANILA, FIRST DISTRICT', '13', '1339');
INSERT INTO public.refprovince VALUES (69, '133900000', 'CITY OF MANILA', '13', '1339');
INSERT INTO public.refprovince VALUES (70, '137400000', 'NCR, SECOND DISTRICT', '13', '1374');
INSERT INTO public.refprovince VALUES (71, '137500000', 'NCR, THIRD DISTRICT', '13', '1375');
INSERT INTO public.refprovince VALUES (72, '137600000', 'NCR, FOURTH DISTRICT', '13', '1376');
INSERT INTO public.refprovince VALUES (73, '140100000', 'ABRA', '14', '1401');
INSERT INTO public.refprovince VALUES (74, '141100000', 'BENGUET', '14', '1411');
INSERT INTO public.refprovince VALUES (75, '142700000', 'IFUGAO', '14', '1427');
INSERT INTO public.refprovince VALUES (76, '143200000', 'KALINGA', '14', '1432');
INSERT INTO public.refprovince VALUES (77, '144400000', 'MOUNTAIN PROVINCE', '14', '1444');
INSERT INTO public.refprovince VALUES (78, '148100000', 'APAYAO', '14', '1481');
INSERT INTO public.refprovince VALUES (79, '150700000', 'BASILAN', '15', '1507');
INSERT INTO public.refprovince VALUES (80, '153600000', 'LANAO DEL SUR', '15', '1536');
INSERT INTO public.refprovince VALUES (81, '153800000', 'MAGUINDANAO', '15', '1538');
INSERT INTO public.refprovince VALUES (82, '156600000', 'SULU', '15', '1566');
INSERT INTO public.refprovince VALUES (83, '157000000', 'TAWI-TAWI', '15', '1570');
INSERT INTO public.refprovince VALUES (84, '160200000', 'AGUSAN DEL NORTE', '16', '1602');
INSERT INTO public.refprovince VALUES (85, '160300000', 'AGUSAN DEL SUR', '16', '1603');
INSERT INTO public.refprovince VALUES (86, '166700000', 'SURIGAO DEL NORTE', '16', '1667');
INSERT INTO public.refprovince VALUES (87, '166800000', 'SURIGAO DEL SUR', '16', '1668');
INSERT INTO public.refprovince VALUES (88, '168500000', 'DINAGAT ISLANDS', '16', '1685');


-- Completed on 2025-10-05 10:06:17 PST

--
-- PostgreSQL database dump complete
--

