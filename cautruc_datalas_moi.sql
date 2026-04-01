--
-- PostgreSQL database dump
--

\restrict VJN4DebQSBN6hEkAgvEP4nNnLhfUTWbb9O8caSVSDcaYtiOqDl5TvSSiBtB5OEN

-- Dumped from database version 18.1
-- Dumped by pg_dump version 18.1

-- Started on 2026-04-02 01:24:57

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
-- TOC entry 242 (class 1259 OID 24873)
-- Name: cau_hinh_truong; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cau_hinh_truong (
    cht_ma integer NOT NULL,
    cht_ten_hien_thi character varying(255),
    cht_ten_bien character varying(50),
    cht_kieu_du_lieu character varying(20),
    cht_mac_dinh double precision,
    pt_ma integer
);


ALTER TABLE public.cau_hinh_truong OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 24872)
-- Name: cau_hinh_truong_cht_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cau_hinh_truong_cht_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cau_hinh_truong_cht_ma_seq OWNER TO postgres;

--
-- TOC entry 5172 (class 0 OID 0)
-- Dependencies: 241
-- Name: cau_hinh_truong_cht_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cau_hinh_truong_cht_ma_seq OWNED BY public.cau_hinh_truong.cht_ma;


--
-- TOC entry 240 (class 1259 OID 24855)
-- Name: chi_dinh_phep_thu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chi_dinh_phep_thu (
    cdpt_ma integer NOT NULL,
    mtn_ma integer,
    pt_ma integer
);


ALTER TABLE public.chi_dinh_phep_thu OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 24854)
-- Name: chi_dinh_phep_thu_cdpt_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chi_dinh_phep_thu_cdpt_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.chi_dinh_phep_thu_cdpt_ma_seq OWNER TO postgres;

--
-- TOC entry 5173 (class 0 OID 0)
-- Dependencies: 239
-- Name: chi_dinh_phep_thu_cdpt_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.chi_dinh_phep_thu_cdpt_ma_seq OWNED BY public.chi_dinh_phep_thu.cdpt_ma;


--
-- TOC entry 220 (class 1259 OID 24615)
-- Name: chuc_vu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chuc_vu (
    cv_ma integer NOT NULL,
    cv_ten character varying(50) NOT NULL
);


ALTER TABLE public.chuc_vu OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 24614)
-- Name: chuc_vu_cv_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chuc_vu_cv_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.chuc_vu_cv_ma_seq OWNER TO postgres;

--
-- TOC entry 5174 (class 0 OID 0)
-- Dependencies: 219
-- Name: chuc_vu_cv_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.chuc_vu_cv_ma_seq OWNED BY public.chuc_vu.cv_ma;


--
-- TOC entry 236 (class 1259 OID 24801)
-- Name: chung_loai; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chung_loai (
    cl_ma integer NOT NULL,
    lvl_ma integer,
    cl_ten character varying(255) NOT NULL,
    cl_cong_thuc text,
    cl_don_vi character varying(50),
    nvl_ma integer
);


ALTER TABLE public.chung_loai OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 24800)
-- Name: chung_loai_cl_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chung_loai_cl_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.chung_loai_cl_ma_seq OWNER TO postgres;

--
-- TOC entry 5175 (class 0 OID 0)
-- Dependencies: 235
-- Name: chung_loai_cl_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.chung_loai_cl_ma_seq OWNED BY public.chung_loai.cl_ma;


--
-- TOC entry 224 (class 1259 OID 24644)
-- Name: don_vi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.don_vi (
    dv_ma integer NOT NULL,
    dv_ten character varying(255) NOT NULL
);


ALTER TABLE public.don_vi OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 24643)
-- Name: don_vi_dv_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.don_vi_dv_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.don_vi_dv_ma_seq OWNER TO postgres;

--
-- TOC entry 5176 (class 0 OID 0)
-- Dependencies: 223
-- Name: don_vi_dv_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.don_vi_dv_ma_seq OWNED BY public.don_vi.dv_ma;


--
-- TOC entry 226 (class 1259 OID 24655)
-- Name: du_an; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.du_an (
    da_ma integer NOT NULL,
    da_ten character varying(255) NOT NULL,
    da_diachi text,
    da_ngay_bat_dau date DEFAULT CURRENT_DATE,
    da_ma_hieu character varying(50)
);


ALTER TABLE public.du_an OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 24654)
-- Name: du_an_da_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.du_an_da_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.du_an_da_ma_seq OWNER TO postgres;

--
-- TOC entry 5177 (class 0 OID 0)
-- Dependencies: 225
-- Name: du_an_da_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.du_an_da_ma_seq OWNED BY public.du_an.da_ma;


--
-- TOC entry 232 (class 1259 OID 24771)
-- Name: du_an_don_vi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.du_an_don_vi (
    dadv_ma integer NOT NULL,
    da_ma integer,
    dv_ma integer,
    vai_tro character varying(100) NOT NULL
);


ALTER TABLE public.du_an_don_vi OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 24770)
-- Name: du_an_don_vi_dadv_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.du_an_don_vi_dadv_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.du_an_don_vi_dadv_ma_seq OWNER TO postgres;

--
-- TOC entry 5178 (class 0 OID 0)
-- Dependencies: 231
-- Name: du_an_don_vi_dadv_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.du_an_don_vi_dadv_ma_seq OWNED BY public.du_an_don_vi.dadv_ma;


--
-- TOC entry 230 (class 1259 OID 24710)
-- Name: ket_qua_thi_nghiem; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ket_qua_thi_nghiem (
    kq_ma integer NOT NULL,
    pyc_ma integer,
    pt_ma integer,
    nv_thuc_hien integer,
    kq_du_lieu_tho jsonb,
    kq_ket_luan text,
    ngay_ky_duyet date,
    mtn_ma integer,
    cong_thuc_su_dung text
);


ALTER TABLE public.ket_qua_thi_nghiem OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 24709)
-- Name: ket_qua_thi_nghiem_kq_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ket_qua_thi_nghiem_kq_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ket_qua_thi_nghiem_kq_ma_seq OWNER TO postgres;

--
-- TOC entry 5179 (class 0 OID 0)
-- Dependencies: 229
-- Name: ket_qua_thi_nghiem_kq_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ket_qua_thi_nghiem_kq_ma_seq OWNED BY public.ket_qua_thi_nghiem.kq_ma;


--
-- TOC entry 234 (class 1259 OID 24790)
-- Name: loai_vat_lieu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.loai_vat_lieu (
    lvl_ma integer NOT NULL,
    lvl_ten character varying(255) NOT NULL
);


ALTER TABLE public.loai_vat_lieu OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 24789)
-- Name: loai_vat_lieu_lvl_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.loai_vat_lieu_lvl_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.loai_vat_lieu_lvl_ma_seq OWNER TO postgres;

--
-- TOC entry 5180 (class 0 OID 0)
-- Dependencies: 233
-- Name: loai_vat_lieu_lvl_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.loai_vat_lieu_lvl_ma_seq OWNED BY public.loai_vat_lieu.lvl_ma;


--
-- TOC entry 238 (class 1259 OID 24829)
-- Name: mau_thi_nghiem; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mau_thi_nghiem (
    mtn_ma integer NOT NULL,
    pyc_ma integer,
    cl_ma integer,
    mtn_so_luong integer DEFAULT 1,
    mtn_ngay_lay date,
    mtn_ghi_chu text
);


ALTER TABLE public.mau_thi_nghiem OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 24828)
-- Name: mau_thi_nghiem_mtn_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mau_thi_nghiem_mtn_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.mau_thi_nghiem_mtn_ma_seq OWNER TO postgres;

--
-- TOC entry 5181 (class 0 OID 0)
-- Dependencies: 237
-- Name: mau_thi_nghiem_mtn_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mau_thi_nghiem_mtn_ma_seq OWNED BY public.mau_thi_nghiem.mtn_ma;


--
-- TOC entry 222 (class 1259 OID 24626)
-- Name: nhan_vien; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nhan_vien (
    nv_ma integer NOT NULL,
    nv_tendn character varying(50) NOT NULL,
    nv_matkhau character varying(255) NOT NULL,
    nv_ten character varying(100) NOT NULL,
    nv_sdt character varying(15),
    cv_ma integer
);


ALTER TABLE public.nhan_vien OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 24625)
-- Name: nhan_vien_nv_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nhan_vien_nv_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nhan_vien_nv_ma_seq OWNER TO postgres;

--
-- TOC entry 5182 (class 0 OID 0)
-- Dependencies: 221
-- Name: nhan_vien_nv_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nhan_vien_nv_ma_seq OWNED BY public.nhan_vien.nv_ma;


--
-- TOC entry 246 (class 1259 OID 24919)
-- Name: nhom_vat_lieu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nhom_vat_lieu (
    nvl_ma integer NOT NULL,
    nvl_ten character varying(255) NOT NULL
);


ALTER TABLE public.nhom_vat_lieu OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 24918)
-- Name: nhom_vat_lieu_nvl_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nhom_vat_lieu_nvl_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nhom_vat_lieu_nvl_ma_seq OWNER TO postgres;

--
-- TOC entry 5183 (class 0 OID 0)
-- Dependencies: 245
-- Name: nhom_vat_lieu_nvl_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nhom_vat_lieu_nvl_ma_seq OWNED BY public.nhom_vat_lieu.nvl_ma;


--
-- TOC entry 244 (class 1259 OID 24898)
-- Name: phep_thu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.phep_thu (
    pt_ma integer NOT NULL,
    cl_ma integer,
    pt_ten character varying(255) NOT NULL,
    pt_cong_thuc text,
    pt_don_vi character varying(50),
    pt_tieu_chuan character varying(100)
);


ALTER TABLE public.phep_thu OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 24897)
-- Name: phep_thu_pt_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.phep_thu_pt_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.phep_thu_pt_ma_seq OWNER TO postgres;

--
-- TOC entry 5184 (class 0 OID 0)
-- Dependencies: 243
-- Name: phep_thu_pt_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.phep_thu_pt_ma_seq OWNED BY public.phep_thu.pt_ma;


--
-- TOC entry 228 (class 1259 OID 24687)
-- Name: phieu_yeu_cau; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.phieu_yeu_cau (
    pyc_ma integer NOT NULL,
    pyc_so_phieu character varying(50) NOT NULL,
    da_ma integer,
    nv_lap_phieu integer,
    pyc_ngay_nhan_mau date DEFAULT CURRENT_DATE,
    pyc_trang_thai character varying(50) DEFAULT 'Chờ thí nghiệm'::character varying
);


ALTER TABLE public.phieu_yeu_cau OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 24686)
-- Name: phieu_yeu_cau_pyc_ma_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.phieu_yeu_cau_pyc_ma_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.phieu_yeu_cau_pyc_ma_seq OWNER TO postgres;

--
-- TOC entry 5185 (class 0 OID 0)
-- Dependencies: 227
-- Name: phieu_yeu_cau_pyc_ma_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.phieu_yeu_cau_pyc_ma_seq OWNED BY public.phieu_yeu_cau.pyc_ma;


--
-- TOC entry 4936 (class 2604 OID 24876)
-- Name: cau_hinh_truong cht_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cau_hinh_truong ALTER COLUMN cht_ma SET DEFAULT nextval('public.cau_hinh_truong_cht_ma_seq'::regclass);


--
-- TOC entry 4935 (class 2604 OID 24858)
-- Name: chi_dinh_phep_thu cdpt_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chi_dinh_phep_thu ALTER COLUMN cdpt_ma SET DEFAULT nextval('public.chi_dinh_phep_thu_cdpt_ma_seq'::regclass);


--
-- TOC entry 4921 (class 2604 OID 24618)
-- Name: chuc_vu cv_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chuc_vu ALTER COLUMN cv_ma SET DEFAULT nextval('public.chuc_vu_cv_ma_seq'::regclass);


--
-- TOC entry 4932 (class 2604 OID 24804)
-- Name: chung_loai cl_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chung_loai ALTER COLUMN cl_ma SET DEFAULT nextval('public.chung_loai_cl_ma_seq'::regclass);


--
-- TOC entry 4923 (class 2604 OID 24647)
-- Name: don_vi dv_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.don_vi ALTER COLUMN dv_ma SET DEFAULT nextval('public.don_vi_dv_ma_seq'::regclass);


--
-- TOC entry 4924 (class 2604 OID 24658)
-- Name: du_an da_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an ALTER COLUMN da_ma SET DEFAULT nextval('public.du_an_da_ma_seq'::regclass);


--
-- TOC entry 4930 (class 2604 OID 24774)
-- Name: du_an_don_vi dadv_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an_don_vi ALTER COLUMN dadv_ma SET DEFAULT nextval('public.du_an_don_vi_dadv_ma_seq'::regclass);


--
-- TOC entry 4929 (class 2604 OID 24713)
-- Name: ket_qua_thi_nghiem kq_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem ALTER COLUMN kq_ma SET DEFAULT nextval('public.ket_qua_thi_nghiem_kq_ma_seq'::regclass);


--
-- TOC entry 4931 (class 2604 OID 24793)
-- Name: loai_vat_lieu lvl_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.loai_vat_lieu ALTER COLUMN lvl_ma SET DEFAULT nextval('public.loai_vat_lieu_lvl_ma_seq'::regclass);


--
-- TOC entry 4933 (class 2604 OID 24832)
-- Name: mau_thi_nghiem mtn_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mau_thi_nghiem ALTER COLUMN mtn_ma SET DEFAULT nextval('public.mau_thi_nghiem_mtn_ma_seq'::regclass);


--
-- TOC entry 4922 (class 2604 OID 24629)
-- Name: nhan_vien nv_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhan_vien ALTER COLUMN nv_ma SET DEFAULT nextval('public.nhan_vien_nv_ma_seq'::regclass);


--
-- TOC entry 4938 (class 2604 OID 24922)
-- Name: nhom_vat_lieu nvl_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhom_vat_lieu ALTER COLUMN nvl_ma SET DEFAULT nextval('public.nhom_vat_lieu_nvl_ma_seq'::regclass);


--
-- TOC entry 4937 (class 2604 OID 24901)
-- Name: phep_thu pt_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phep_thu ALTER COLUMN pt_ma SET DEFAULT nextval('public.phep_thu_pt_ma_seq'::regclass);


--
-- TOC entry 4926 (class 2604 OID 24690)
-- Name: phieu_yeu_cau pyc_ma; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phieu_yeu_cau ALTER COLUMN pyc_ma SET DEFAULT nextval('public.phieu_yeu_cau_pyc_ma_seq'::regclass);


--
-- TOC entry 5162 (class 0 OID 24873)
-- Dependencies: 242
-- Data for Name: cau_hinh_truong; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cau_hinh_truong (cht_ma, cht_ten_hien_thi, cht_ten_bien, cht_kieu_du_lieu, cht_mac_dinh, pt_ma) FROM stdin;
7	Cạnh a (mm)	a	number	\N	\N
8	Cạnh b (mm)	b	number	\N	\N
9	Lực nén P (kN)	p	number	\N	\N
10	Đường kính (mm)	d	number	\N	\N
11	Lực phá hủy (kN)	p	number	\N	\N
17	Đường kính (mm)	d	number	\N	14
18	Lực kéo đứt (kN)	p	number	\N	14
19	Cạnh a (mm)	a	number	\N	15
20	Cạnh b (mm)	b	number	\N	15
21	Lực phá hủy (kN)	p	number	\N	15
\.


--
-- TOC entry 5160 (class 0 OID 24855)
-- Dependencies: 240
-- Data for Name: chi_dinh_phep_thu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chi_dinh_phep_thu (cdpt_ma, mtn_ma, pt_ma) FROM stdin;
\.


--
-- TOC entry 5140 (class 0 OID 24615)
-- Dependencies: 220
-- Data for Name: chuc_vu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chuc_vu (cv_ma, cv_ten) FROM stdin;
1	Admin
2	Trưởng phòng
3	Thí nghiệm viên
\.


--
-- TOC entry 5156 (class 0 OID 24801)
-- Dependencies: 236
-- Data for Name: chung_loai; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chung_loai (cl_ma, lvl_ma, cl_ten, cl_cong_thuc, cl_don_vi, nvl_ma) FROM stdin;
1	1	Bê tông lập phương 15x15x15 cm	(P*1000)/(a*b)	\N	1
2	1	Bê tông hình trụ 15x30 cm	(P*1000)/(3.14159*(d/2)*(d/2))	\N	1
3	2	Thép thanh vằn	\N	\N	3
4	2	Thép thanh tròn trơn	\N	\N	3
5	3	Cát vàng (cát đổ bê tông)	\N	\N	2
6	3	Cát san lấp	\N	\N	2
9	\N	Đá 0x4	\N	\N	5
10	\N	Thép hộp	\N	\N	3
7	4	Đá 1x2	\N	\N	5
\.


--
-- TOC entry 5144 (class 0 OID 24644)
-- Dependencies: 224
-- Data for Name: don_vi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.don_vi (dv_ma, dv_ten) FROM stdin;
2	Công ty TNHH Thanh Hảo
1	Công ty Beda
3	Công ty TNHH Đức Trọng 
4	Công ty XD Zeta
5	Công ty TNHH TV TK Vinaco
6	Công ty TNHH Vy Việt
7	Ban QLDA Giá Rai
\.


--
-- TOC entry 5146 (class 0 OID 24655)
-- Dependencies: 226
-- Data for Name: du_an; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.du_an (da_ma, da_ten, da_diachi, da_ngay_bat_dau, da_ma_hieu) FROM stdin;
\.


--
-- TOC entry 5152 (class 0 OID 24771)
-- Dependencies: 232
-- Data for Name: du_an_don_vi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.du_an_don_vi (dadv_ma, da_ma, dv_ma, vai_tro) FROM stdin;
\.


--
-- TOC entry 5150 (class 0 OID 24710)
-- Dependencies: 230
-- Data for Name: ket_qua_thi_nghiem; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ket_qua_thi_nghiem (kq_ma, pyc_ma, pt_ma, nv_thuc_hien, kq_du_lieu_tho, kq_ket_luan, ngay_ky_duyet, mtn_ma, cong_thuc_su_dung) FROM stdin;
\.


--
-- TOC entry 5154 (class 0 OID 24790)
-- Dependencies: 234
-- Data for Name: loai_vat_lieu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.loai_vat_lieu (lvl_ma, lvl_ten) FROM stdin;
1	Bê tông
2	Thép xây dựng
3	Cát xây dựng
4	Đá dăm
\.


--
-- TOC entry 5158 (class 0 OID 24829)
-- Dependencies: 238
-- Data for Name: mau_thi_nghiem; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mau_thi_nghiem (mtn_ma, pyc_ma, cl_ma, mtn_so_luong, mtn_ngay_lay, mtn_ghi_chu) FROM stdin;
\.


--
-- TOC entry 5142 (class 0 OID 24626)
-- Dependencies: 222
-- Data for Name: nhan_vien; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nhan_vien (nv_ma, nv_tendn, nv_matkhau, nv_ten, nv_sdt, cv_ma) FROM stdin;
1	admin	$2y$12$NmfmQbwU142IMGTaMmHx9eAAO6dBm8SamnLfNd6cZF05fA0gejcrW	Quản trị viên	0909999000	1
4	ngoc2712	$2y$12$ReXvBGBZjnO3btNRzA6Jj.kXeaLs.EXGoPye3ABLRJuMcHoJM3GCy	Liên Bảo Ngọc	0949828483	2
3	kythuat01	$2y$12$qlPFgaSESVG9eWzKVgcExuTuUy2to/eaAeTuWnJTBsNeASV0/NJai	Trần Quốc Nghiêm	09911223344	2
6	caoanhkhoa	$2y$12$Sm1miKiG1L4syeGK3d5SIuzWdpPILwS3G0mZTRlbPNN5q8ZtgBvJ2	Cao Anh Khoa	0919567567	3
\.


--
-- TOC entry 5166 (class 0 OID 24919)
-- Dependencies: 246
-- Data for Name: nhom_vat_lieu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nhom_vat_lieu (nvl_ma, nvl_ten) FROM stdin;
1	Bê tông
2	Cát
3	Thép
5	Đá
6	Xi măng
\.


--
-- TOC entry 5164 (class 0 OID 24898)
-- Dependencies: 244
-- Data for Name: phep_thu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.phep_thu (pt_ma, cl_ma, pt_ten, pt_cong_thuc, pt_don_vi, pt_tieu_chuan) FROM stdin;
14	3	Thử cường độ kéo	p*1000/d		\N
15	1	Thử cường độ nén	(p*1000)/(a*b)	MPa	\N
\.


--
-- TOC entry 5148 (class 0 OID 24687)
-- Dependencies: 228
-- Data for Name: phieu_yeu_cau; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.phieu_yeu_cau (pyc_ma, pyc_so_phieu, da_ma, nv_lap_phieu, pyc_ngay_nhan_mau, pyc_trang_thai) FROM stdin;
\.


--
-- TOC entry 5186 (class 0 OID 0)
-- Dependencies: 241
-- Name: cau_hinh_truong_cht_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cau_hinh_truong_cht_ma_seq', 21, true);


--
-- TOC entry 5187 (class 0 OID 0)
-- Dependencies: 239
-- Name: chi_dinh_phep_thu_cdpt_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chi_dinh_phep_thu_cdpt_ma_seq', 1, false);


--
-- TOC entry 5188 (class 0 OID 0)
-- Dependencies: 219
-- Name: chuc_vu_cv_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chuc_vu_cv_ma_seq', 3, true);


--
-- TOC entry 5189 (class 0 OID 0)
-- Dependencies: 235
-- Name: chung_loai_cl_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chung_loai_cl_ma_seq', 10, true);


--
-- TOC entry 5190 (class 0 OID 0)
-- Dependencies: 223
-- Name: don_vi_dv_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.don_vi_dv_ma_seq', 7, true);


--
-- TOC entry 5191 (class 0 OID 0)
-- Dependencies: 225
-- Name: du_an_da_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.du_an_da_ma_seq', 1, false);


--
-- TOC entry 5192 (class 0 OID 0)
-- Dependencies: 231
-- Name: du_an_don_vi_dadv_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.du_an_don_vi_dadv_ma_seq', 1, false);


--
-- TOC entry 5193 (class 0 OID 0)
-- Dependencies: 229
-- Name: ket_qua_thi_nghiem_kq_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ket_qua_thi_nghiem_kq_ma_seq', 1, false);


--
-- TOC entry 5194 (class 0 OID 0)
-- Dependencies: 233
-- Name: loai_vat_lieu_lvl_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.loai_vat_lieu_lvl_ma_seq', 4, true);


--
-- TOC entry 5195 (class 0 OID 0)
-- Dependencies: 237
-- Name: mau_thi_nghiem_mtn_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mau_thi_nghiem_mtn_ma_seq', 1, false);


--
-- TOC entry 5196 (class 0 OID 0)
-- Dependencies: 221
-- Name: nhan_vien_nv_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nhan_vien_nv_ma_seq', 6, true);


--
-- TOC entry 5197 (class 0 OID 0)
-- Dependencies: 245
-- Name: nhom_vat_lieu_nvl_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nhom_vat_lieu_nvl_ma_seq', 6, true);


--
-- TOC entry 5198 (class 0 OID 0)
-- Dependencies: 243
-- Name: phep_thu_pt_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.phep_thu_pt_ma_seq', 15, true);


--
-- TOC entry 5199 (class 0 OID 0)
-- Dependencies: 227
-- Name: phieu_yeu_cau_pyc_ma_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.phieu_yeu_cau_pyc_ma_seq', 1, false);


--
-- TOC entry 4970 (class 2606 OID 24879)
-- Name: cau_hinh_truong cau_hinh_truong_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cau_hinh_truong
    ADD CONSTRAINT cau_hinh_truong_pkey PRIMARY KEY (cht_ma);


--
-- TOC entry 4968 (class 2606 OID 24861)
-- Name: chi_dinh_phep_thu chi_dinh_phep_thu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chi_dinh_phep_thu
    ADD CONSTRAINT chi_dinh_phep_thu_pkey PRIMARY KEY (cdpt_ma);


--
-- TOC entry 4940 (class 2606 OID 24624)
-- Name: chuc_vu chuc_vu_cv_ten_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chuc_vu
    ADD CONSTRAINT chuc_vu_cv_ten_key UNIQUE (cv_ten);


--
-- TOC entry 4942 (class 2606 OID 24622)
-- Name: chuc_vu chuc_vu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chuc_vu
    ADD CONSTRAINT chuc_vu_pkey PRIMARY KEY (cv_ma);


--
-- TOC entry 4964 (class 2606 OID 24808)
-- Name: chung_loai chung_loai_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chung_loai
    ADD CONSTRAINT chung_loai_pkey PRIMARY KEY (cl_ma);


--
-- TOC entry 4948 (class 2606 OID 24653)
-- Name: don_vi don_vi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.don_vi
    ADD CONSTRAINT don_vi_pkey PRIMARY KEY (dv_ma);


--
-- TOC entry 4958 (class 2606 OID 24778)
-- Name: du_an_don_vi du_an_don_vi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an_don_vi
    ADD CONSTRAINT du_an_don_vi_pkey PRIMARY KEY (dadv_ma);


--
-- TOC entry 4950 (class 2606 OID 24665)
-- Name: du_an du_an_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an
    ADD CONSTRAINT du_an_pkey PRIMARY KEY (da_ma);


--
-- TOC entry 4956 (class 2606 OID 24718)
-- Name: ket_qua_thi_nghiem ket_qua_thi_nghiem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem
    ADD CONSTRAINT ket_qua_thi_nghiem_pkey PRIMARY KEY (kq_ma);


--
-- TOC entry 4960 (class 2606 OID 24799)
-- Name: loai_vat_lieu loai_vat_lieu_lvl_ten_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.loai_vat_lieu
    ADD CONSTRAINT loai_vat_lieu_lvl_ten_key UNIQUE (lvl_ten);


--
-- TOC entry 4962 (class 2606 OID 24797)
-- Name: loai_vat_lieu loai_vat_lieu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.loai_vat_lieu
    ADD CONSTRAINT loai_vat_lieu_pkey PRIMARY KEY (lvl_ma);


--
-- TOC entry 4966 (class 2606 OID 24838)
-- Name: mau_thi_nghiem mau_thi_nghiem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mau_thi_nghiem
    ADD CONSTRAINT mau_thi_nghiem_pkey PRIMARY KEY (mtn_ma);


--
-- TOC entry 4944 (class 2606 OID 24637)
-- Name: nhan_vien nhan_vien_nv_tendn_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhan_vien
    ADD CONSTRAINT nhan_vien_nv_tendn_key UNIQUE (nv_tendn);


--
-- TOC entry 4946 (class 2606 OID 24635)
-- Name: nhan_vien nhan_vien_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhan_vien
    ADD CONSTRAINT nhan_vien_pkey PRIMARY KEY (nv_ma);


--
-- TOC entry 4974 (class 2606 OID 24926)
-- Name: nhom_vat_lieu nhom_vat_lieu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhom_vat_lieu
    ADD CONSTRAINT nhom_vat_lieu_pkey PRIMARY KEY (nvl_ma);


--
-- TOC entry 4972 (class 2606 OID 24907)
-- Name: phep_thu phep_thu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phep_thu
    ADD CONSTRAINT phep_thu_pkey PRIMARY KEY (pt_ma);


--
-- TOC entry 4952 (class 2606 OID 24696)
-- Name: phieu_yeu_cau phieu_yeu_cau_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phieu_yeu_cau
    ADD CONSTRAINT phieu_yeu_cau_pkey PRIMARY KEY (pyc_ma);


--
-- TOC entry 4954 (class 2606 OID 24698)
-- Name: phieu_yeu_cau phieu_yeu_cau_pyc_so_phieu_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phieu_yeu_cau
    ADD CONSTRAINT phieu_yeu_cau_pyc_so_phieu_key UNIQUE (pyc_so_phieu);


--
-- TOC entry 4988 (class 2606 OID 24862)
-- Name: chi_dinh_phep_thu chi_dinh_phep_thu_mtn_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chi_dinh_phep_thu
    ADD CONSTRAINT chi_dinh_phep_thu_mtn_ma_fkey FOREIGN KEY (mtn_ma) REFERENCES public.mau_thi_nghiem(mtn_ma) ON DELETE CASCADE;


--
-- TOC entry 4989 (class 2606 OID 24962)
-- Name: chi_dinh_phep_thu chi_dinh_phep_thu_pt_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chi_dinh_phep_thu
    ADD CONSTRAINT chi_dinh_phep_thu_pt_ma_fkey FOREIGN KEY (pt_ma) REFERENCES public.phep_thu(pt_ma) ON DELETE CASCADE;


--
-- TOC entry 4984 (class 2606 OID 24809)
-- Name: chung_loai chung_loai_lvl_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chung_loai
    ADD CONSTRAINT chung_loai_lvl_ma_fkey FOREIGN KEY (lvl_ma) REFERENCES public.loai_vat_lieu(lvl_ma) ON DELETE CASCADE;


--
-- TOC entry 4982 (class 2606 OID 24779)
-- Name: du_an_don_vi du_an_don_vi_da_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an_don_vi
    ADD CONSTRAINT du_an_don_vi_da_ma_fkey FOREIGN KEY (da_ma) REFERENCES public.du_an(da_ma) ON DELETE CASCADE;


--
-- TOC entry 4983 (class 2606 OID 24784)
-- Name: du_an_don_vi du_an_don_vi_dv_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.du_an_don_vi
    ADD CONSTRAINT du_an_don_vi_dv_ma_fkey FOREIGN KEY (dv_ma) REFERENCES public.don_vi(dv_ma) ON DELETE CASCADE;


--
-- TOC entry 4990 (class 2606 OID 24913)
-- Name: cau_hinh_truong fk_cht_pt; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cau_hinh_truong
    ADD CONSTRAINT fk_cht_pt FOREIGN KEY (pt_ma) REFERENCES public.phep_thu(pt_ma) ON DELETE CASCADE;


--
-- TOC entry 4985 (class 2606 OID 24927)
-- Name: chung_loai fk_cl_nvl; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chung_loai
    ADD CONSTRAINT fk_cl_nvl FOREIGN KEY (nvl_ma) REFERENCES public.nhom_vat_lieu(nvl_ma) ON DELETE SET NULL;


--
-- TOC entry 4991 (class 2606 OID 24908)
-- Name: phep_thu fk_pt_cl; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phep_thu
    ADD CONSTRAINT fk_pt_cl FOREIGN KEY (cl_ma) REFERENCES public.chung_loai(cl_ma) ON DELETE CASCADE;


--
-- TOC entry 4978 (class 2606 OID 24967)
-- Name: ket_qua_thi_nghiem ket_qua_thi_nghiem_mtn_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem
    ADD CONSTRAINT ket_qua_thi_nghiem_mtn_ma_fkey FOREIGN KEY (mtn_ma) REFERENCES public.mau_thi_nghiem(mtn_ma) ON DELETE CASCADE;


--
-- TOC entry 4979 (class 2606 OID 24729)
-- Name: ket_qua_thi_nghiem ket_qua_thi_nghiem_nv_thuc_hien_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem
    ADD CONSTRAINT ket_qua_thi_nghiem_nv_thuc_hien_fkey FOREIGN KEY (nv_thuc_hien) REFERENCES public.nhan_vien(nv_ma);


--
-- TOC entry 4980 (class 2606 OID 24972)
-- Name: ket_qua_thi_nghiem ket_qua_thi_nghiem_pt_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem
    ADD CONSTRAINT ket_qua_thi_nghiem_pt_ma_fkey FOREIGN KEY (pt_ma) REFERENCES public.phep_thu(pt_ma) ON DELETE CASCADE;


--
-- TOC entry 4981 (class 2606 OID 24719)
-- Name: ket_qua_thi_nghiem ket_qua_thi_nghiem_pyc_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ket_qua_thi_nghiem
    ADD CONSTRAINT ket_qua_thi_nghiem_pyc_ma_fkey FOREIGN KEY (pyc_ma) REFERENCES public.phieu_yeu_cau(pyc_ma) ON DELETE CASCADE;


--
-- TOC entry 4986 (class 2606 OID 24849)
-- Name: mau_thi_nghiem mau_thi_nghiem_cl_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mau_thi_nghiem
    ADD CONSTRAINT mau_thi_nghiem_cl_ma_fkey FOREIGN KEY (cl_ma) REFERENCES public.chung_loai(cl_ma);


--
-- TOC entry 4987 (class 2606 OID 24839)
-- Name: mau_thi_nghiem mau_thi_nghiem_pyc_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mau_thi_nghiem
    ADD CONSTRAINT mau_thi_nghiem_pyc_ma_fkey FOREIGN KEY (pyc_ma) REFERENCES public.phieu_yeu_cau(pyc_ma) ON DELETE CASCADE;


--
-- TOC entry 4975 (class 2606 OID 24638)
-- Name: nhan_vien nhan_vien_cv_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhan_vien
    ADD CONSTRAINT nhan_vien_cv_ma_fkey FOREIGN KEY (cv_ma) REFERENCES public.chuc_vu(cv_ma) ON DELETE SET NULL;


--
-- TOC entry 4976 (class 2606 OID 24699)
-- Name: phieu_yeu_cau phieu_yeu_cau_da_ma_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phieu_yeu_cau
    ADD CONSTRAINT phieu_yeu_cau_da_ma_fkey FOREIGN KEY (da_ma) REFERENCES public.du_an(da_ma) ON DELETE CASCADE;


--
-- TOC entry 4977 (class 2606 OID 24704)
-- Name: phieu_yeu_cau phieu_yeu_cau_nv_lap_phieu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phieu_yeu_cau
    ADD CONSTRAINT phieu_yeu_cau_nv_lap_phieu_fkey FOREIGN KEY (nv_lap_phieu) REFERENCES public.nhan_vien(nv_ma);


-- Completed on 2026-04-02 01:24:57

--
-- PostgreSQL database dump complete
--

\unrestrict VJN4DebQSBN6hEkAgvEP4nNnLhfUTWbb9O8caSVSDcaYtiOqDl5TvSSiBtB5OEN

