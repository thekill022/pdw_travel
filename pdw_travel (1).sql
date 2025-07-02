CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `idPaket` int(11) DEFAULT NULL,
  `jadwal_awal` date DEFAULT NULL,
  `jadwal_akhir` date DEFAULT NULL
)


INSERT INTO `jadwal` (`id_jadwal`, `idPaket`, `jadwal_awal`, `jadwal_akhir`) VALUES
(1, 3, '2025-06-30', '2025-07-08');


CREATE TABLE `paketliburan` (
  `idPaket` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` double(10,2) DEFAULT NULL,
  `path` text DEFAULT NULL
)

INSERT INTO `paketliburan` (`idPaket`, `nama`, `deskripsi`, `harga`, `path`) VALUES
(3, 'Bali, Indonesia', 'Pulau Dewata yang terkenal dengan pantai pasir putih, budaya Hindu yang kental, pura eksotis, dan kehidupan malam yang meriah. Cocok untuk relaksasi maupun petualangan.', 1500000.00, 'assets/img/destination/bali.jpeg'),
(4, 'Tokyo, Jepang', 'Metropolis modern dengan teknologi canggih, kuil kuno, taman sakura, dan kuliner unik seperti sushi dan ramen. Kombinasi budaya tradisional dan futuristik.', 5500000.00, 'assets/img/destination/tokyo.jpeg'),
(5, 'Raja Ampat, Indonesia', 'Destinasi diving kelas dunia dengan terumbu karang terbaik, air laut jernih, dan pemandangan pulau tropis yang masih alami. Cocok untuk pencinta alam.', 3500000.00, 'assets/img/destination/raja-ampat.jpeg'),
(6, 'Bangkok, Thailand', 'Ibu kota Thailand dengan wisata belanja murah, kuil emas, pasar malam yang ramai, dan street food lezat. Seru untuk wisata belanja dan kuliner.', 2500000.00, 'assets/img/destination/bangkok.jpeg');


CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  `status` enum('sukses','gagal') NOT NULL
)

INSERT INTO `peserta` (`id_peserta`, `nama`, `email`, `no_hp`, `id`, `id_jadwal`, `status`) VALUES
(1, 'GIBRAN FATHONI BELVA', 'gibran.fathoni.ft23@mail.umy.ac.id', '081338653791', 9, 1, 'sukses'),
(2, 'Bob', 'bobby@gmail.com', '081234567890', 9, 1, 'sukses'),
(5, 'GIBRAN FATHONI ', 'gibran.fathoni.ft23@mail.umy.ac.id', '081338653791', 9, 1, 'sukses');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Member') NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
)

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `status`) VALUES
(2, 'Gibran Fathoni B', 'gibfathoni', '$2y$10$R6Cc3FDhCKDZMLizU0t8Y.9kjMpY6VlPyP3aMGreiTbOc0vTKpQki', 'Admin', 1),
(9, 'Duta Brahmana', 'dutalinggau', '$2y$10$cfmpxZR0FKdS6EHH4o33ZezlXBVfvI3.XAa1W0i3njGk7LUUsw6ja', 'Member', 1),
(10, 'Asroni', 'asroni', '$2y$10$KFzsdCELL1UmgRzo9hUIheki2mK8FvbE3R2TUfUty4pYxUT/B50G.', 'Member', 0);

CREATE TABLE `vw_berangkat` (
`id_peserta` int(11)
,`nama_peserta` varchar(255)
,`nama_paket` varchar(255)
,`jadwal` varchar(25)
,`status` enum('sukses','gagal')
);

DROP TABLE IF EXISTS `vw_berangkat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_berangkat`  AS SELECT `p`.`id_peserta` AS `id_peserta`, `p`.`nama` AS `nama_peserta`, `pl`.`nama` AS `nama_paket`, concat(`j`.`jadwal_awal`,' s.d ',`j`.`jadwal_akhir`) AS `jadwal`, `p`.`status` AS `status` FROM ((`peserta` `p` join `jadwal` `j` on(`p`.`id_jadwal` = `j`.`id_jadwal`)) join `paketliburan` `pl` on(`j`.`idPaket` = `pl`.`idPaket`)) ;

ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `fk_user` (`idPaket`);

ALTER TABLE `paketliburan`
  ADD PRIMARY KEY (`idPaket`),
  ADD UNIQUE KEY `uq_nama` (`nama`);

ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `fk_users` (`id`),
  ADD KEY `fk_jadwal` (`id_jadwal`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_username` (`username`);

ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `paketliburan`
  MODIFY `idPaket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`idPaket`) REFERENCES `paketliburan` (`idPaket`) ON DELETE CASCADE;

ALTER TABLE `peserta`
  ADD CONSTRAINT `fk_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;