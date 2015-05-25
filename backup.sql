--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

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
-- Name: kurangi_total_pinjaman(); Type: FUNCTION; Schema: public; Owner: milezoom
--

CREATE FUNCTION kurangi_total_pinjaman() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                   
begin                         
    update anggota 
    set total_pinjaman = total_pinjaman - new.jumlah
    where no_anggota in(              
    select no_anggota 
    from transaksi_pinjaman
    where transaksi_pinjaman.kode_trans = new.kode_trans);
    
    update transaksi_pinjaman
    set sisa_piutang = sisa_piutang - new.jumlah
    where kode_trans = new.kode_trans;
    return new;
end;
$$;


ALTER FUNCTION public.kurangi_total_pinjaman() OWNER TO milezoom;

--
-- Name: tambah_sisa_piutang(); Type: FUNCTION; Schema: public; Owner: milezoom
--

CREATE FUNCTION tambah_sisa_piutang() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                   

begin                         

    update transaksi_pinjaman 

    set sisa_piutang = new.jumlah

    where transaksi_pinjaman.kode_trans = new.kode_trans;
	
	return new;

end;

$$;


ALTER FUNCTION public.tambah_sisa_piutang() OWNER TO milezoom;

--
-- Name: tambah_total_pinjaman(); Type: FUNCTION; Schema: public; Owner: milezoom
--

CREATE FUNCTION tambah_total_pinjaman() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                   
begin
    update anggota 
    set total_pinjaman = total_pinjaman + new.jumlah
    where no_anggota = new.no_anggota;
    return new; 
end;
$$;


ALTER FUNCTION public.tambah_total_pinjaman() OWNER TO milezoom;

--
-- Name: update_total_simpanan(); Type: FUNCTION; Schema: public; Owner: milezoom
--

CREATE FUNCTION update_total_simpanan() RETURNS trigger
    LANGUAGE plpgsql
    AS $$                   
begin
    if(new.kode_simpanan like '%SPSKRL%') then
    update anggota 
    set total_simpanan = total_simpanan + new.jumlah
    where no_anggota = new.no_anggota;
    update anggota
    set total_simpanan_sukarela = total_simpanan_sukarela + new.jumlah
    where no_anggota = new.no_anggota;
    return new;
    
    elsif(new.kode_simpanan like '%SPWJB%') then
    update anggota 
    set total_simpanan = total_simpanan + new.jumlah
    where no_anggota = new.no_anggota;
    update anggota
    set total_simpanan_wajib = total_simpanan_wajib + new.jumlah
    where no_anggota = new.no_anggota;
    return new;
    
    elsif(new.kode_simpanan like '%AMSP%') then
    update anggota 
    set total_simpanan = total_simpanan - new.jumlah
    where no_anggota = new.no_anggota;
    update anggota
    set total_simpanan_sukarela = total_simpanan_sukarela - new.jumlah
    where no_anggota = new.no_anggota;
    return new;

    end if; 
end;
$$;


ALTER FUNCTION public.update_total_simpanan() OWNER TO milezoom;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: anggota; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE anggota (
    no_anggota integer NOT NULL,
    nama character varying(30) NOT NULL,
    kode_unit character(10) NOT NULL,
    alamat character varying(150),
    tgl_lahir date,
    no_telepon character varying(15),
    jenis_kelamin character varying(20) NOT NULL,
    thn_pensiun smallint NOT NULL,
    status character varying(5) NOT NULL,
    is_pns character varying(20) NOT NULL,
    no_ktp character(16),
    tgl_masuk date,
    total_simpanan integer DEFAULT 0,
    total_pinjaman integer DEFAULT 0,
    total_simpanan_wajib integer DEFAULT 0,
    total_simpanan_sukarela integer DEFAULT 0
);


ALTER TABLE anggota OWNER TO milezoom;

--
-- Name: anggota_no_anggota_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE anggota_no_anggota_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anggota_no_anggota_seq OWNER TO milezoom;

--
-- Name: anggota_no_anggota_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: milezoom
--

ALTER SEQUENCE anggota_no_anggota_seq OWNED BY anggota.no_anggota;


--
-- Name: barang_kode_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE barang_kode_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE barang_kode_seq OWNER TO milezoom;

--
-- Name: barang; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE barang (
    kode integer DEFAULT nextval('barang_kode_seq'::regclass) NOT NULL,
    nama character varying(30) NOT NULL,
    harga integer NOT NULL,
    img_path character varying(150)
);


ALTER TABLE barang OWNER TO milezoom;

--
-- Name: jenis_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE jenis_pinjaman (
    kode character(10) NOT NULL,
    jenis character varying(30) NOT NULL
);


ALTER TABLE jenis_pinjaman OWNER TO milezoom;

--
-- Name: jenis_simpanan; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE jenis_simpanan (
    kode character(10) NOT NULL,
    jenis character varying(30) NOT NULL
);


ALTER TABLE jenis_simpanan OWNER TO milezoom;

--
-- Name: pembayaran_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE pembayaran_pinjaman (
    kode_trans integer NOT NULL,
    tgl_bayar date NOT NULL,
    no_angsuran smallint NOT NULL,
    jumlah integer NOT NULL,
    denda integer,
    jasa integer
);


ALTER TABLE pembayaran_pinjaman OWNER TO milezoom;

--
-- Name: settingan; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE settingan (
    key character varying(20) NOT NULL,
    value integer NOT NULL
);


ALTER TABLE settingan OWNER TO milezoom;

--
-- Name: transaksi_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE transaksi_pinjaman (
    kode_trans integer NOT NULL,
    kode_pinjaman character(10) NOT NULL,
    no_anggota integer NOT NULL,
    jumlah integer NOT NULL,
    sisa_piutang integer DEFAULT 0,
    tgl_pinjam date NOT NULL,
    banyak_angsuran smallint NOT NULL,
    kode_barang integer,
    jatuh_tempo date NOT NULL
);


ALTER TABLE transaksi_pinjaman OWNER TO milezoom;

--
-- Name: transaksi_pinjaman_kode_trans_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE transaksi_pinjaman_kode_trans_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE transaksi_pinjaman_kode_trans_seq OWNER TO milezoom;

--
-- Name: transaksi_pinjaman_kode_trans_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: milezoom
--

ALTER SEQUENCE transaksi_pinjaman_kode_trans_seq OWNED BY transaksi_pinjaman.kode_trans;


--
-- Name: transaksi_simpanan; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE transaksi_simpanan (
    kode_trans integer NOT NULL,
    kode_simpanan character(10) NOT NULL,
    tanggal date NOT NULL,
    no_anggota integer NOT NULL,
    jumlah integer NOT NULL,
    keterangan character varying(50)
);


ALTER TABLE transaksi_simpanan OWNER TO milezoom;

--
-- Name: transaksi_simpanan_kode_trans_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE transaksi_simpanan_kode_trans_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE transaksi_simpanan_kode_trans_seq OWNER TO milezoom;

--
-- Name: transaksi_simpanan_kode_trans_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: milezoom
--

ALTER SEQUENCE transaksi_simpanan_kode_trans_seq OWNED BY transaksi_simpanan.kode_trans;


--
-- Name: unit; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE unit (
    kode character(10) NOT NULL,
    nama character varying(30) NOT NULL
);


ALTER TABLE unit OWNER TO milezoom;

--
-- Name: user; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    username character varying(25) NOT NULL,
    password character varying(60) NOT NULL,
    auth_key character varying(255) NOT NULL,
    no_anggota integer NOT NULL,
    role character varying(7) DEFAULT 'anggota'::character varying NOT NULL
);


ALTER TABLE "user" OWNER TO milezoom;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_id_seq OWNER TO milezoom;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: milezoom
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: no_anggota; Type: DEFAULT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY anggota ALTER COLUMN no_anggota SET DEFAULT nextval('anggota_no_anggota_seq'::regclass);


--
-- Name: kode_trans; Type: DEFAULT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_pinjaman ALTER COLUMN kode_trans SET DEFAULT nextval('transaksi_pinjaman_kode_trans_seq'::regclass);


--
-- Name: kode_trans; Type: DEFAULT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_simpanan ALTER COLUMN kode_trans SET DEFAULT nextval('transaksi_simpanan_kode_trans_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Data for Name: anggota; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY anggota (no_anggota, nama, kode_unit, alamat, tgl_lahir, no_telepon, jenis_kelamin, thn_pensiun, status, is_pns, no_ktp, tgl_masuk, total_simpanan, total_pinjaman, total_simpanan_wajib, total_simpanan_sukarela) FROM stdin;
1	Muslim	0000000017		\N		Laki Laki	2020	Aktif	P-UI	                	\N	10000000	0	10000000	0
2	Hussein	0000000051		\N		Laki Laki	2030	Aktif	PNS	                	\N	0	200000	0	0
3	Utari Azzahra Putri	0000000015	Jl Kukel No 21	1995-01-12		Perempuan	2020	Aktif	P-UI	                	2015-05-25	0	0	0	0
\.


--
-- Name: anggota_no_anggota_seq; Type: SEQUENCE SET; Schema: public; Owner: milezoom
--

SELECT pg_catalog.setval('anggota_no_anggota_seq', 3, true);


--
-- Data for Name: barang; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY barang (kode, nama, harga, img_path) FROM stdin;
\.


--
-- Name: barang_kode_seq; Type: SEQUENCE SET; Schema: public; Owner: milezoom
--

SELECT pg_catalog.setval('barang_kode_seq', 1, false);


--
-- Data for Name: jenis_pinjaman; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY jenis_pinjaman (kode, jenis) FROM stdin;
PJUG      	Pinjaman Uang
PJBG      	Pinjaman Barang
\.


--
-- Data for Name: jenis_simpanan; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY jenis_simpanan (kode, jenis) FROM stdin;
SPSKRL    	Simpanan Sukarela
SPWJB     	Simpanan Wajib
AMSP      	Ambil Simpanan
\.


--
-- Data for Name: pembayaran_pinjaman; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY pembayaran_pinjaman (kode_trans, tgl_bayar, no_angsuran, jumlah, denda, jasa) FROM stdin;
\.


--
-- Data for Name: settingan; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY settingan (key, value) FROM stdin;
SP	100000
Bunga	1
Denda	3
\.


--
-- Data for Name: transaksi_pinjaman; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY transaksi_pinjaman (kode_trans, kode_pinjaman, no_anggota, jumlah, sisa_piutang, tgl_pinjam, banyak_angsuran, kode_barang, jatuh_tempo) FROM stdin;
2	PJUG      	2	100000	100000	2015-05-16	5	\N	2015-06-05
4	PJUG      	2	100000	100000	2015-05-16	10	\N	2015-06-15
\.


--
-- Name: transaksi_pinjaman_kode_trans_seq; Type: SEQUENCE SET; Schema: public; Owner: milezoom
--

SELECT pg_catalog.setval('transaksi_pinjaman_kode_trans_seq', 4, true);


--
-- Data for Name: transaksi_simpanan; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY transaksi_simpanan (kode_trans, kode_simpanan, tanggal, no_anggota, jumlah, keterangan) FROM stdin;
2	SPWJB     	2015-05-23	1	10000000	\N
\.


--
-- Name: transaksi_simpanan_kode_trans_seq; Type: SEQUENCE SET; Schema: public; Owner: milezoom
--

SELECT pg_catalog.setval('transaksi_simpanan_kode_trans_seq', 2, true);


--
-- Data for Name: unit; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY unit (kode, nama) FROM stdin;
0000000001	Akuntansi
0000000002	Alumni
0000000003	Arsip
0000000004	Asrama
0000000005	BAI
0000000006	BPMA
0000000007	CDC
0000000008	Daya Makara
0000000009	DGB
0000000010	DIIB
0000000011	Dikara Putri
0000000012	DPA
0000000013	DRPM
0000000014	Farmasi
0000000015	Fasilkom
0000000016	FEB UI
0000000017	FH UI
0000000018	FIB UI
0000000019	FIK
0000000020	FISIP
0000000021	FK UI
0000000022	FKG UI
0000000023	FKM UI
0000000024	FMIPA UI
0000000025	FT UI
0000000026	Humas
0000000027	IO
0000000028	Kemahasiswaan
0000000029	Kerjasama
0000000030	Keuangan
0000000031	Koperasi
0000000032	KPHP
0000000033	Logistik
0000000034	Masjid
0000000035	Pasca Sarjana
0000000036	Pendidikan
0000000037	Perpustakaan
0000000038	PKM UI
0000000039	PMB
0000000040	PMU
0000000041	PPSI
0000000042	PPSP
0000000043	Psikologi
0000000044	PSJ UI
0000000045	Pusilkom
0000000046	RenBang
0000000047	RIK
0000000048	RT
0000000049	SAU
0000000050	Sekr. Rektor
0000000051	SU
0000000052	TU
0000000053	ULP
0000000054	Umum & Fasilitas
0000000055	UPT. PLK
0000000056	Vokasi
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY "user" (id, username, password, auth_key, no_anggota, role) FROM stdin;
1	muslim1	$2y$13$WvZPs9paNvdxmGgIvVGrnOBaQWAyNNypPehA0EYG58E.cmWABvHvq	tUHP07jstuLP2QWufEviTUy5qy4RmR6gunmrounF68GstYrJjllfjdjoDF4v3p7qmE6uz6mhgDV0uUayOWSwyUAitsq9uA8T8rW8dfr-8F6zkP-Zq4CTKt1fhVhFZaEBgfBqX2kVmgrM-HO3yWSmOLdclWBL-Otfa5ri810TSByL0xSwV3PNnU03igpcVINTQvTyxDyVvzO-3HXSqEAIpy00Y0GO3NPhjcDtr4oyjTd4qV8DUaTL-SyEgI33iiw	1	admin
2	hussein2	$2y$13$GM0AY.iFROXFfse0hanpeO3UWVuPc.TmayukGxllVGuwjc/lg1Ft6	xy_Pn0Dtxm0uMphEvSHVlHjBi_uotVweTd6gLMhSr4J7n6JszfF9nF2-5zFHLS0PT1xN8yZ2aIfso5YRTkUdJ5foVpQJOkR-0JETf_11oXVXGlk_Qdy3iX42j5NkT9H7u9JSl0tvsWH5wkKS1QQaDHsUrUmGlDZU2610mweH_Y7F13d5FPNqczFz9AnQHJJXeUizAaAttku-0ZnkunUPtGQJ084DblMZ0vZ6Eeh7NwFjLCpUhrFGsczjVy7azDO	2	admin
4	utari3	$2y$13$nV7/juqLdp5x3pqZ.tWT2OzxnDonXctd2PmVC5A9C.idjiTrRESVi	LXQ24v27EoMG9cblOjqqPt0Ym58qxpl7trd1OgUT8IsZLx9Kg3XnFNExm8wijypSCrxS963nQO1QvqTkag3iSglCM2K0ryF_a4z1qwLCgSn06ZvojFG5rBR7MqCmCD8yn-zIWd-NORE76vy6M5cWyugqu9msora_01svsb22wH3ysckSIFhHXUV4a2mt-gJNn0--LW6Ygd5f0RMrDAAU2jxoYDl8huDV3xUW-LgGFBQjINuMFFvAufeULle6t60	3	anggota
\.


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: milezoom
--

SELECT pg_catalog.setval('user_id_seq', 4, true);


--
-- Name: anggota_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY anggota
    ADD CONSTRAINT anggota_pkey PRIMARY KEY (no_anggota);


--
-- Name: barang_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY barang
    ADD CONSTRAINT barang_pkey PRIMARY KEY (kode);


--
-- Name: jenis_pinjaman_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY jenis_pinjaman
    ADD CONSTRAINT jenis_pinjaman_pkey PRIMARY KEY (kode);


--
-- Name: pembayaran_pinjaman_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY pembayaran_pinjaman
    ADD CONSTRAINT pembayaran_pinjaman_pkey PRIMARY KEY (kode_trans, tgl_bayar);


--
-- Name: settingan_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY settingan
    ADD CONSTRAINT settingan_pkey PRIMARY KEY (key);


--
-- Name: tipe_simpanan_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY jenis_simpanan
    ADD CONSTRAINT tipe_simpanan_pkey PRIMARY KEY (kode);


--
-- Name: transaksi_pinjaman_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY transaksi_pinjaman
    ADD CONSTRAINT transaksi_pinjaman_pkey PRIMARY KEY (kode_trans);


--
-- Name: transaksi_simpanan_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY transaksi_simpanan
    ADD CONSTRAINT transaksi_simpanan_pkey PRIMARY KEY (kode_trans);


--
-- Name: unit_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY unit
    ADD CONSTRAINT unit_pkey PRIMARY KEY (kode);


--
-- Name: user_auth_key_key; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_auth_key_key UNIQUE (auth_key);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: trg_tambah_sisa_piutang; Type: TRIGGER; Schema: public; Owner: milezoom
--

CREATE TRIGGER trg_tambah_sisa_piutang AFTER INSERT ON transaksi_pinjaman FOR EACH ROW EXECUTE PROCEDURE tambah_sisa_piutang();


--
-- Name: trg_transaksi_pinjaman_kurangi; Type: TRIGGER; Schema: public; Owner: milezoom
--

CREATE TRIGGER trg_transaksi_pinjaman_kurangi AFTER INSERT ON pembayaran_pinjaman FOR EACH ROW EXECUTE PROCEDURE kurangi_total_pinjaman();


--
-- Name: trg_transaksi_pinjaman_tambah; Type: TRIGGER; Schema: public; Owner: milezoom
--

CREATE TRIGGER trg_transaksi_pinjaman_tambah AFTER INSERT ON transaksi_pinjaman FOR EACH ROW EXECUTE PROCEDURE tambah_total_pinjaman();


--
-- Name: trg_transaksi_simpanan_insert; Type: TRIGGER; Schema: public; Owner: milezoom
--

CREATE TRIGGER trg_transaksi_simpanan_insert AFTER INSERT OR UPDATE ON transaksi_simpanan FOR EACH ROW EXECUTE PROCEDURE update_total_simpanan();


--
-- Name: anggota_kode_unit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY anggota
    ADD CONSTRAINT anggota_kode_unit_fkey FOREIGN KEY (kode_unit) REFERENCES unit(kode) ON UPDATE CASCADE;


--
-- Name: pembayaran_pinjaman_kode_trans_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY pembayaran_pinjaman
    ADD CONSTRAINT pembayaran_pinjaman_kode_trans_fkey FOREIGN KEY (kode_trans) REFERENCES transaksi_pinjaman(kode_trans) ON UPDATE CASCADE;


--
-- Name: transaksi_pinjaman_kode_barang_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_pinjaman
    ADD CONSTRAINT transaksi_pinjaman_kode_barang_fkey FOREIGN KEY (kode_barang) REFERENCES barang(kode) ON UPDATE CASCADE;


--
-- Name: transaksi_pinjaman_kode_pinjaman_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_pinjaman
    ADD CONSTRAINT transaksi_pinjaman_kode_pinjaman_fkey FOREIGN KEY (kode_pinjaman) REFERENCES jenis_pinjaman(kode) ON UPDATE CASCADE;


--
-- Name: transaksi_pinjaman_no_anggota_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_pinjaman
    ADD CONSTRAINT transaksi_pinjaman_no_anggota_fkey FOREIGN KEY (no_anggota) REFERENCES anggota(no_anggota) ON UPDATE CASCADE;


--
-- Name: transaksi_simpanan_kode_simpanan_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_simpanan
    ADD CONSTRAINT transaksi_simpanan_kode_simpanan_fkey FOREIGN KEY (kode_simpanan) REFERENCES jenis_simpanan(kode) ON UPDATE CASCADE;


--
-- Name: transaksi_simpanan_no_anggota_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY transaksi_simpanan
    ADD CONSTRAINT transaksi_simpanan_no_anggota_fkey FOREIGN KEY (no_anggota) REFERENCES anggota(no_anggota) ON UPDATE CASCADE;


--
-- Name: user_no_anggota_fkey; Type: FK CONSTRAINT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_no_anggota_fkey FOREIGN KEY (no_anggota) REFERENCES anggota(no_anggota) ON UPDATE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

