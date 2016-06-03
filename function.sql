CREATE OR REPLACE FUNCTION tambah_anggota_baru() RETURNS trigger AS $$
DECLARE pokok int; wajib int; sosial int;
BEGIN
    SELECT (value) INTO pokok FROM site_variable WHERE key = 'Simpanan Pokok';
    SELECT (value) INTO wajib FROM site_variable WHERE key = 'Simpanan Wajib';
    SELECT (value) INTO sosial FROM site_variable WHERE key = 'Dana Sosial';

    UPDATE anggota SET
        total_simpanan = pokok+wajib,
        total_simpanan_pokok = pokok,
        total_simpanan_wajib = wajib,
        total_dana_sosial = sosial
    WHERE no_anggota = NEW.no_anggota;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql VOLATILE;

--

CREATE OR REPLACE FUNCTION tambah_simpanan() RETURNS trigger AS $$
BEGIN
    UPDATE anggota SET
        total_simpanan_wajib = total_simpanan_wajib+NEW.simpanan_wajib,
        total_simpanan_sukarela = total_simpanan_sukarela+NEW.simpanan_sukarela,
        total_dana_sosial = total_dana_sosial+NEW.dana_sosial
    WHERE no_anggota = NEW.no_anggota;

    IF NEW.simpanan_wajib > 0 THEN
        UPDATE anggota SET tgl_bayar_simpanan_terakhir = NEW.tanggal WHERE no_anggota = NEW.no_anggota;
    END IF;

    IF NEW.dana_sosial > 0 THEN
        UPDATE site_variable SET value = value+NEW.dana_sosial WHERE key = 'Total Dana Sosial';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql VOLATILE;

--

CREATE OR REPLACE FUNCTION tambah_pinjaman() RETURNS trigger AS $$
BEGIN
    UPDATE anggota SET
        total_pinjaman = total_pinjaman+NEW.pinjaman_uang+NEW.kredit_barang,
        total_pinjaman_uang = total_pinjaman_uang+NEW.pinjaman.uang,
        total_kredit_barang = total_kredit_barang+NEW.kredit_barang
    WHERE no_anggota = NEW.no_anggota;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql VOLATILE;

--

CREATE OR REPLACE FUNCTION bayar_pinjaman() RETURNS trigger AS $$
DECLARE sisa int;
BEGIN
    UPDATE transaksi_pinjaman
    SET
        sisa_pinjaman = sisa_pinjaman-NEW.besar_pembayaran_pokok,
        sisa_angsuran = sisa_angsuran-1
    WHERE id = NEW.id_pinjaman;

    SELECT sisa_pinjaman INTO sisa
    FROM transaksi_pinjaman
    WHERE id = NEW.id_pinjaman;

    IF sisa = 0 THEN
        UPDATE transaksi_pinjaman
        SET sisa_angsuran = 0
        WHERE id = NEW.id_pinjaman;
    END IF;

    UPDATE anggota SET
        total_jasa = total_jasa+NEW.besar_pembayaran_jasa,
        total_denda = total_denda+NEW.besar_pembayaran_denda
    WHERE no_anggota IN(
        SELECT no_anggota FROM transaksi_pinjaman WHERE id = NEW.id_pinjaman
    );

    RETURN NEW;
END;
$$ LANGUAGE plpgsql VOLATILE;

--

CREATE OR REPLACE FUNCTION ambil_dana_sosial() RETURNS trigger AS $$
BEGIN
    UPDATE site_variable
    SET value = value-NEW.besar_pengeluaran
    WHERE key = 'Total Dana Sosial';

    RETURN NEW;
END;
$$ LANGUAGE plpgsql VOLATILE;

--

CREATE TRIGGER trg_tambah_anggota_baru
AFTER INSERT ON anggota
FOR EACH ROW
EXECUTE PROCEDURE tambah_anggota_baru();

--

CREATE TRIGGER trg_tambah_simpanan
AFTER INSERT ON transaksi_simpanan
FOR EACH ROW
EXECUTE PROCEDURE tambah_simpanan();

--

CREATE TRIGGER trg_tambah_pinjaman
AFTER INSERT ON transaksi_pinjaman
FOR EACH ROW
EXECUTE PROCEDURE tambah_pinjaman();

--

CREATE TRIGGER trg_bayar_pinjaman
AFTER INSERT ON pembayaran_pinjaman
FOR EACH ROW
EXECUTE PROCEDURE bayar_pinjaman();

--

CREATE TRIGGER trg_ambil_dana_sosial
AFTER INSERT ON dana_sosial
FOR EACH ROW
EXECUTE PROCEDURE ambil_dana_sosial();
