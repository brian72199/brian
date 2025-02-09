PGDMP  9             	        |            it_prof    16.3    16.3 3    )           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            *           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            +           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            ,           1262    16398    it_prof    DATABASE     �   CREATE DATABASE it_prof WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE it_prof;
                postgres    false                        2615    16399    elective    SCHEMA        CREATE SCHEMA elective;
    DROP SCHEMA elective;
                postgres    false            �            1259    16448    application_files    TABLE       CREATE TABLE elective.application_files (
    file_id integer NOT NULL,
    application_id integer,
    file_name character varying(255),
    file_type character varying(50),
    file_url text,
    upload_date timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);
 '   DROP TABLE elective.application_files;
       elective         heap    postgres    false    6            �            1259    16454    application_files_file_id_seq    SEQUENCE     �   CREATE SEQUENCE elective.application_files_file_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE elective.application_files_file_id_seq;
       elective          postgres    false    6    223            -           0    0    application_files_file_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE elective.application_files_file_id_seq OWNED BY elective.application_files.file_id;
          elective          postgres    false    225            �            1259    16429    applications    TABLE     {  CREATE TABLE elective.applications (
    application_id integer NOT NULL,
    user_id integer,
    job_id integer,
    application_date timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    exam_score integer,
    interview_score integer,
    trail character varying(100),
    schedule_time timestamp with time zone,
    schedule_date date,
    status character varying(20)
);
 "   DROP TABLE elective.applications;
       elective         heap    postgres    false    6            �            1259    16428    applications_application_id_seq    SEQUENCE     �   CREATE SEQUENCE elective.applications_application_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 8   DROP SEQUENCE elective.applications_application_id_seq;
       elective          postgres    false    222    6            .           0    0    applications_application_id_seq    SEQUENCE OWNED BY     g   ALTER SEQUENCE elective.applications_application_id_seq OWNED BY elective.applications.application_id;
          elective          postgres    false    221            �            1259    16408    jobs    TABLE     �   CREATE TABLE elective.jobs (
    job_id integer NOT NULL,
    job_title character varying(100),
    job_description character varying(255),
    trail character varying(254),
    staff_id integer
);
    DROP TABLE elective.jobs;
       elective         heap    postgres    false    6            �            1259    16419    jobs_job_id_seq    SEQUENCE     �   ALTER TABLE elective.jobs ALTER COLUMN job_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME elective.jobs_job_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            elective          postgres    false    217    6            �            1259    16482    notifications    TABLE       CREATE TABLE elective.notifications (
    notification_id integer NOT NULL,
    user_id integer,
    message text NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    is_read boolean DEFAULT false,
    trail character varying(50)
);
 #   DROP TABLE elective.notifications;
       elective         heap    postgres    false    6            �            1259    16481 !   notifications_notification_id_seq    SEQUENCE     �   CREATE SEQUENCE elective.notifications_notification_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 :   DROP SEQUENCE elective.notifications_notification_id_seq;
       elective          postgres    false    227    6            /           0    0 !   notifications_notification_id_seq    SEQUENCE OWNED BY     k   ALTER SEQUENCE elective.notifications_notification_id_seq OWNED BY elective.notifications.notification_id;
          elective          postgres    false    226            �            1259    16451 	   privilege    TABLE     y   CREATE TABLE elective.privilege (
    privilege_id integer NOT NULL,
    privilege_description character varying(100)
);
    DROP TABLE elective.privilege;
       elective         heap    postgres    false    6            �            1259    16414    staffs    TABLE       CREATE TABLE elective.staffs (
    staff_id integer NOT NULL,
    firstname character varying(50),
    lastname character varying(50),
    staff_description character varying(254),
    username character varying(50),
    password character varying(50),
    privilege integer
);
    DROP TABLE elective.staffs;
       elective         heap    postgres    false    6            �            1259    16413    staffs_staff_id_seq    SEQUENCE     �   ALTER TABLE elective.staffs ALTER COLUMN staff_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME elective.staffs_staff_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            elective          postgres    false    219    6            �            1259    16400    users    TABLE     �  CREATE TABLE elective.users (
    user_id integer NOT NULL,
    firstname character varying(50),
    lastname character varying(50),
    birthdate date,
    address character varying(255),
    username character varying(50),
    password character varying(50),
    email character varying(254),
    mobile_number character varying(15),
    suffix character varying(5),
    middlename character varying(50)
);
    DROP TABLE elective.users;
       elective         heap    postgres    false    6            �            1259    16498    users_user_id_seq    SEQUENCE     �   ALTER TABLE elective.users ALTER COLUMN user_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME elective.users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            elective          postgres    false    216    6            p           2604    16455    application_files file_id    DEFAULT     �   ALTER TABLE ONLY elective.application_files ALTER COLUMN file_id SET DEFAULT nextval('elective.application_files_file_id_seq'::regclass);
 J   ALTER TABLE elective.application_files ALTER COLUMN file_id DROP DEFAULT;
       elective          postgres    false    225    223            n           2604    16432    applications application_id    DEFAULT     �   ALTER TABLE ONLY elective.applications ALTER COLUMN application_id SET DEFAULT nextval('elective.applications_application_id_seq'::regclass);
 L   ALTER TABLE elective.applications ALTER COLUMN application_id DROP DEFAULT;
       elective          postgres    false    221    222    222            r           2604    16485    notifications notification_id    DEFAULT     �   ALTER TABLE ONLY elective.notifications ALTER COLUMN notification_id SET DEFAULT nextval('elective.notifications_notification_id_seq'::regclass);
 N   ALTER TABLE elective.notifications ALTER COLUMN notification_id DROP DEFAULT;
       elective          postgres    false    226    227    227            !          0    16448    application_files 
   TABLE DATA           s   COPY elective.application_files (file_id, application_id, file_name, file_type, file_url, upload_date) FROM stdin;
    elective          postgres    false    223   �A                  0    16429    applications 
   TABLE DATA           �   COPY elective.applications (application_id, user_id, job_id, application_date, exam_score, interview_score, trail, schedule_time, schedule_date, status) FROM stdin;
    elective          postgres    false    222   �A                 0    16408    jobs 
   TABLE DATA           U   COPY elective.jobs (job_id, job_title, job_description, trail, staff_id) FROM stdin;
    elective          postgres    false    217   �A       %          0    16482    notifications 
   TABLE DATA           h   COPY elective.notifications (notification_id, user_id, message, created_at, is_read, trail) FROM stdin;
    elective          postgres    false    227   �C       "          0    16451 	   privilege 
   TABLE DATA           J   COPY elective.privilege (privilege_id, privilege_description) FROM stdin;
    elective          postgres    false    224   �C                 0    16414    staffs 
   TABLE DATA           s   COPY elective.staffs (staff_id, firstname, lastname, staff_description, username, password, privilege) FROM stdin;
    elective          postgres    false    219   )D                 0    16400    users 
   TABLE DATA           �   COPY elective.users (user_id, firstname, lastname, birthdate, address, username, password, email, mobile_number, suffix, middlename) FROM stdin;
    elective          postgres    false    216   DE       0           0    0    application_files_file_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('elective.application_files_file_id_seq', 1, false);
          elective          postgres    false    225            1           0    0    applications_application_id_seq    SEQUENCE SET     P   SELECT pg_catalog.setval('elective.applications_application_id_seq', 1, false);
          elective          postgres    false    221            2           0    0    jobs_job_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('elective.jobs_job_id_seq', 17, true);
          elective          postgres    false    220            3           0    0 !   notifications_notification_id_seq    SEQUENCE SET     R   SELECT pg_catalog.setval('elective.notifications_notification_id_seq', 1, false);
          elective          postgres    false    226            4           0    0    staffs_staff_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('elective.staffs_staff_id_seq', 20, true);
          elective          postgres    false    218            5           0    0    users_user_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('elective.users_user_id_seq', 8, true);
          elective          postgres    false    228            �           2606    16463 (   application_files application_files_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY elective.application_files
    ADD CONSTRAINT application_files_pkey PRIMARY KEY (file_id);
 T   ALTER TABLE ONLY elective.application_files DROP CONSTRAINT application_files_pkey;
       elective            postgres    false    223            |           2606    16435    applications applications_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY elective.applications
    ADD CONSTRAINT applications_pkey PRIMARY KEY (application_id);
 J   ALTER TABLE ONLY elective.applications DROP CONSTRAINT applications_pkey;
       elective            postgres    false    222            x           2606    16412    jobs jobs_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY elective.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (job_id);
 :   ALTER TABLE ONLY elective.jobs DROP CONSTRAINT jobs_pkey;
       elective            postgres    false    217            �           2606    16491     notifications notifications_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY elective.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (notification_id);
 L   ALTER TABLE ONLY elective.notifications DROP CONSTRAINT notifications_pkey;
       elective            postgres    false    227            �           2606    16470    privilege privilege_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY elective.privilege
    ADD CONSTRAINT privilege_pkey PRIMARY KEY (privilege_id);
 D   ALTER TABLE ONLY elective.privilege DROP CONSTRAINT privilege_pkey;
       elective            postgres    false    224            z           2606    16418    staffs staffs_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY elective.staffs
    ADD CONSTRAINT staffs_pkey PRIMARY KEY (staff_id);
 >   ALTER TABLE ONLY elective.staffs DROP CONSTRAINT staffs_pkey;
       elective            postgres    false    219            ~           2606    16447 (   applications unique_user_job_application 
   CONSTRAINT     p   ALTER TABLE ONLY elective.applications
    ADD CONSTRAINT unique_user_job_application UNIQUE (user_id, job_id);
 T   ALTER TABLE ONLY elective.applications DROP CONSTRAINT unique_user_job_application;
       elective            postgres    false    222    222            v           2606    16406    users users_pkey 
   CONSTRAINT     U   ALTER TABLE ONLY elective.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);
 <   ALTER TABLE ONLY elective.users DROP CONSTRAINT users_pkey;
       elective            postgres    false    216            �           2606    16464 7   application_files application_files_application_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.application_files
    ADD CONSTRAINT application_files_application_id_fkey FOREIGN KEY (application_id) REFERENCES elective.applications(application_id) NOT VALID;
 c   ALTER TABLE ONLY elective.application_files DROP CONSTRAINT application_files_application_id_fkey;
       elective          postgres    false    222    4732    223            �           2606    16441 %   applications applications_job_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.applications
    ADD CONSTRAINT applications_job_id_fkey FOREIGN KEY (job_id) REFERENCES elective.jobs(job_id);
 Q   ALTER TABLE ONLY elective.applications DROP CONSTRAINT applications_job_id_fkey;
       elective          postgres    false    4728    222    217            �           2606    16436 &   applications applications_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.applications
    ADD CONSTRAINT applications_user_id_fkey FOREIGN KEY (user_id) REFERENCES elective.users(user_id);
 R   ALTER TABLE ONLY elective.applications DROP CONSTRAINT applications_user_id_fkey;
       elective          postgres    false    222    4726    216            �           2606    16476    jobs jobs_staff_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.jobs
    ADD CONSTRAINT jobs_staff_id_fkey FOREIGN KEY (staff_id) REFERENCES elective.staffs(staff_id) NOT VALID;
 C   ALTER TABLE ONLY elective.jobs DROP CONSTRAINT jobs_staff_id_fkey;
       elective          postgres    false    217    4730    219            �           2606    16492 (   notifications notifications_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.notifications
    ADD CONSTRAINT notifications_user_id_fkey FOREIGN KEY (user_id) REFERENCES elective.users(user_id);
 T   ALTER TABLE ONLY elective.notifications DROP CONSTRAINT notifications_user_id_fkey;
       elective          postgres    false    216    4726    227            �           2606    16471    staffs staffs_privilege_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY elective.staffs
    ADD CONSTRAINT staffs_privilege_fkey FOREIGN KEY (privilege) REFERENCES elective.privilege(privilege_id) NOT VALID;
 H   ALTER TABLE ONLY elective.staffs DROP CONSTRAINT staffs_privilege_fkey;
       elective          postgres    false    4738    224    219            !      x������ � �             x������ � �         �  x�uSKo�0>+��? �֮���{��uXP��^���ɔ �q�_?Jn���	��^���-�:O�TEx�=l��Fc2�զ����k����E�M����!r�	������oJ���n�0u}T��[�H'��"����ڹ:>sc���h�ܶ�j�^�,$Q��OC8ۉ3���Y����^��t_�'͠��(��K�5�o��Q� ma8�أ�X�O�X`\�{�oV���
�9��bY��0�cL���d�z:�0aѬO��Y�*���Խ\���d��@!��
�=��{\����xu��}L�+��{�<e^#R��C1|��K��[Ǵ�r�C�nM��s�u�=�!NfC���B$NN�.�	�����nڴH�zxz�p��{d���5���KG��r�Hmݰ����N�	N�d�CvO��u���k��Q��_���Q��ao]�J��0�/V��_o]O      %      x������ � �      "   <   x�3�tN�SH.JM,I�QHM�,�QH�KQHI�I-I�2Ɛ�2���`fYfj9W� ���           x�]O�J�0|�|�_ ��y����/��t��l�kR�{7MRa�d��ٝ��dp��eTO�5fIY���h�f[r3>�0h5z�ۯ9(G7���^X�l�����\,��H�����>�o�:�#3�RnF�jY�|��)1�Z��!��0A
Ya�E��iB ueu٬9����5E�d[	�������H���qL�h�Z�3���8)��%^�n^�7��K�\��%_��;l�^!��ء�f~\�B�r�=v�6���B����         9  x��RMo� =��b���׏�&��ФM=n����F�j5���An%�L�Gx��P���3:6�b���1�׎M��4�䰁u�~?|j{&����py�e�x��i�Qi����&O-���C����>oWJJ��bf��B���BX%	B"e������z�N.�Y���W��FL��$a�!�o��+J����z񔡒:RM)�cKQ'�9�}�X_C�%�n2��cLM��� D�`ME�#�{Az�jQ�No,Oi[�7K��gԟ
���܇�[����Q\�G��q�7迏qI�(��� `     