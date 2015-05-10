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
    select * 
    from transaksi_simpanan
    where transaksi_simpanan.kode_trans = new.kode_trans);
    
    update transaksi_pijaman
    set sisa_piutang = sisa_piutang - new.jumlah
    where kode_trans = new.kode_trans;
    return new;
end;
$$;


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
    set total_simpanan_sukarela = total_simpanan_sukarela + new.jumlah
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

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: anggota; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE anggota (
    no_anggota character varying(20) NOT NULL,
    nama character varying(30) NOT NULL,
    kode_unit character(10) NOT NULL,
    alamat character varying(150) NOT NULL,
    tgl_lahir date NOT NULL,
    no_telepon character varying(15),
    jenis_kelamin boolean NOT NULL,
    thn_pensiun smallint NOT NULL,
    status boolean NOT NULL,
    is_pns boolean NOT NULL,
    no_ktp character(16),
    tgl_masuk date NOT NULL,
    total_simpanan integer DEFAULT 0,
    total_pinjaman integer DEFAULT 0,
    total_simpanan_wajib integer DEFAULT 0,
    total_simpanan_sukarela integer DEFAULT 0
);

--
-- Name: barang; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE barang (
    kode character(10) NOT NULL,
    nama character varying(30) NOT NULL,
    harga integer NOT NULL,
    img_path character varying(150)
);

--
-- Name: jenis_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE jenis_pinjaman (
    kode character(10) NOT NULL,
    jenis character varying(30) NOT NULL
);

--
-- Name: jenis_simpanan; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE jenis_simpanan (
    kode character(10) NOT NULL,
    jenis character varying(30) NOT NULL
);

--
-- Name: pembayaran_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE pembayaran_pinjaman (
    kode_trans character(10) NOT NULL,
    tgl_bayar date NOT NULL,
    no_angsuran smallint NOT NULL,
    jumlah integer NOT NULL,
    keterangan character varying(50) NOT NULL
);

--
-- Name: transaksi_pinjaman; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE transaksi_pinjaman (
    kode_trans character(10) NOT NULL,
    kode_pinjaman character(10) NOT NULL,
    no_anggota character varying(20) NOT NULL,
    jumlah integer NOT NULL,
    sisa_piutang integer NOT NULL,
    tgl_pinjam date NOT NULL,
    jatuh_tempo date NOT NULL,
    banyak_angsuran smallint NOT NULL,
    denda integer NOT NULL,
    bunga double precision NOT NULL,
    kode_barang character(10),
    keterangan character varying(50) NOT NULL
);

--
-- Name: transaksi_simpanan; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE transaksi_simpanan (
    kode_trans character(10) NOT NULL,
    kode_simpanan character(10) NOT NULL,
    tanggal date NOT NULL,
    no_anggota character varying(20) NOT NULL,
    jumlah integer NOT NULL,
    keterangan character varying(50) NOT NULL
);

--
-- Name: unit; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE unit (
    kode character(10) NOT NULL,
    nama character varying(30) NOT NULL,
    lokasi character varying(20) NOT NULL
);

--
-- Name: user; Type: TABLE; Schema: public; Owner: milezoom; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    auth_key character varying(255) NOT NULL,
    no_anggota character varying(20) NOT NULL,
    role character varying(7) DEFAULT 'anggota'::character varying NOT NULL
);

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: milezoom
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: milezoom
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: milezoom
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Data for Name: anggota; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY anggota (no_anggota, nama, kode_unit, alamat, tgl_lahir, no_telepon, jenis_kelamin, thn_pensiun, status, is_pns, no_ktp, tgl_masuk, total_simpanan, total_pinjaman, total_simpanan_wajib, total_simpanan_sukarela) FROM stdin;
2015020002	Hussein Iman	0000000001	8467 Maple Street Coachella, CA 92236	1994-04-28	\N	t	2016	t	f	\N	2015-02-16	750000	0	0	0
2015020003	Utari Azzahra	0000000001	508 6th Avenue Orange, NJ 07050	1995-01-30	\N	f	2016	t	f	\N	2015-02-17	500000	0	0	0
2015030004	Muslim	0000000001	6693 Highland Avenue Uniontown, PA 15401	1994-08-13	\N	t	2016	t	f	\N	2015-03-12	800000	0	0	0
2015010001	Rizka Meutia	0000000001	969 Lincoln Avenue Attleboro, MA 02703	1994-09-17	\N	f	2016	t	f	\N	2015-01-05	500000	0	0	0
\.


--
-- Data for Name: barang; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY barang (kode, nama, harga, img_path) FROM stdin;
BRG0000001	Panci HappyCall	1500000	\N
BRG0000002	Sepatu Nike	250000	\N
BRG0000003	Ricecooker Maspion	750000	\N
\.


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

COPY pembayaran_pinjaman (kode_trans, tgl_bayar, no_angsuran, jumlah, keterangan) FROM stdin;
\.


--
-- Data for Name: transaksi_pinjaman; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY transaksi_pinjaman (kode_trans, kode_pinjaman, no_anggota, jumlah, sisa_piutang, tgl_pinjam, jatuh_tempo, banyak_angsuran, denda, bunga, kode_barang, keterangan) FROM stdin;
\.


--
-- Data for Name: transaksi_simpanan; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY transaksi_simpanan (kode_trans, kode_simpanan, tanggal, no_anggota, jumlah, keterangan) FROM stdin;
SP00000001	SPSKRL    	2015-03-27	2015020002	750000	Iseng
SP00000002	SPSKRL    	2015-04-13	2015010001	500000	Iseng
SP00000003	SPWJB     	2015-04-29	2015020003	200000	Iseng
SP00000004	SPSKRL    	2015-04-30	2015030004	1000000	Iseng
SP00000005	SPWJB     	2015-05-01	2015020003	300000	Iseng
\.


--
-- Data for Name: unit; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY unit (kode, nama, lokasi) FROM stdin;
0000000001	Fasilkom	Gedung Bundar
0000000002	Rektorat	Gedung Rumah Susun
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: milezoom
--

COPY "user" (id, username, password, auth_key, no_anggota, role) FROM stdin;
1	rizka.meutia	$2y$13$INXqjXVMEEHac5g3PkqEh.AOWv.ydNmV9Jger2xwk5KlJn0qALp/2	xQ3xKKbTydxOKbmJKMsDyOL-HVBNZ4yafuayLHzgQDxCikl9YIMGH7KG0dl8SM3z_EJSljBwUIBkftxS-ioPBHen22eAnGWoUwD0DRE-qqU-bWVviDaokR118jIPOIvnvBuqr3A31Im3GMmghdMuvsX-kJbSoYS2xoBNdD6zCIYuToppdLb3Qo3iGrFMA0c4bvDx3VPjlJjiyWVNXt561UkFlTSK1lqUV8FcqO94mTDMFpGk51LZEofQAb_nOjO	2015010001	anggota
3	utari.azzahra	$2y$13$jSwwe2aZlMcGJKbOfN8M3ea1inmZBUeAWptkkHpTQIEsZqY6Obk.W	mFyfaZaOC7YdommfpOh5zBhQk3PO-3y3d26AGMR_sL2-K6o1ma_64IU9K_t8An4z1OJ-4M6X8OtBR4CQRgoW31DAgZSRfZzabdvlkJcjr96o4yDoueVZCASeWiwsm20yaSaxLl0VG2bGM1xCdO85neDMtfAmDu3HlydIZSyvF7lMCIwEOSqXQCs4mAENZi6uyoLVKYlzRDyDyPyxKkCa8axoMluyoinsBL8utmPOYN26KA-Q5FjbeHRMecRP4GM	2015020003	admin
4	muslim	$2y$13$qHfieEqtmN5gHx25BGGhN.KVnEgGlghXMnskX7fFYUvhnUPP5.Tae	CXlOXnlMlr-G68iZbDpHYufilIjFM3CGxJb09U7uccugKCXmD1HME5ore7FouforwsJdc9sLVBTMnf6vamORAD2GLrlF2UzKyTDQ2yj4Ql-MXTBBilC7Ac_Ps0SGWCYCuKD35yg-Dy4889o8EL2LpGlFIdW0IJGjEt128y4Tqrf9O1BDx0jW3v-mqWPbNpiuQclakSShFjM0c9k6idyu5vNCpxPihvii1ru2293zFwzj8gFN05fBYa5WzOikKq9	2015030004	admin
2	hussein.iman	$2y$13$SnJLN8f888BvS9zrqjiwoOsMDwyt9Y7ffTmaKu.HchH2XdyBgEJgC	xNmFf_N5ZcJ3n2N41H2Q9griE7CS4NcGhAvr4XXsD-T4JSOR-eD9Y7Vy9QfQk9ZTxs5kAOZX-lEFLxS87gUhX5c9uvzsZ5vR9VjCAZ106ggYMDYPVKHRm0I35wZ_ipwpm9lTsSKGrK7CQ2mSX_Qgekix5nDZgZdpUluJ8a5DpWZ1NvPLOFyFeSXkXjPQdtYNDN6fVW3siu5yGI8cvM4tfHckm4dnfNNoECQzfdbJOg4LKs8-vnXyhoJPueyvaBC	2015020002	anggota
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
-- Name: user_username_key; Type: CONSTRAINT; Schema: public; Owner: milezoom; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_username_key UNIQUE (username);


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

