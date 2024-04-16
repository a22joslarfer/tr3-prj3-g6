-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-04-2024 a las 09:39:34
-- Versión del servidor: 10.11.5-MariaDB-1:10.11.5+maria~ubu2204
-- Versión de PHP: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `a22hugtrigon_projectofinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`) VALUES
(1, 'Barcelona'),
(2, 'Zaragoza'),
(3, 'Madrid'),
(4, 'Bilbao'),
(5, 'Ibiza'),
(6, 'Huesca'),
(7, 'Galicia'),
(8, 'Cordoba'),
(9, 'Sevilla'),
(10, 'Valencia'),
(11, 'Granada'),
(12, 'Malaga'),
(13, 'Santander'),
(14, 'Salamanca'),
(15, 'Alicante'),
(16, 'Murcia'),
(17, 'Toledo'),
(18, 'Valladolid'),
(19, 'Pamplona'),
(20, 'A Coruña'),
(21, 'Zamora'),
(22, 'Almeria'),
(23, 'Caceres'),
(24, 'Girona'),
(25, 'Jaen'),
(26, 'Lugo'),
(27, 'Ourense'),
(28, 'Teruel'),
(29, 'Badajoz'),
(30, 'Albacete'),
(31, 'Ciudad Real'),
(32, 'Tenerife'),
(33, 'Castellon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discotecas`
--

CREATE TABLE `discotecas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coordenadas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`coordenadas`)),
  `imgUrl` varchar(255) NOT NULL,
  `minEdad` int(11) NOT NULL,
  `horario` varchar(255) NOT NULL,
  `nombre_local` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `discotecas`
--

INSERT INTO `discotecas` (`id`, `coordenadas`, `imgUrl`, `minEdad`, `horario`, `nombre_local`, `telefono`, `descripcion`, `created_at`, `updated_at`, `id_ciudad`) VALUES
(19, '{\"lat\": 40.4168, \"lng\": -3.7038}', 'https://www.emesa-m30.es/wp-content/uploads/2023/04/como-llegar-al-centro-de-madrid.jpg', 18, '22:00 - 04:00', 'Joy Eslava', '+34 111 222 333', 'Iconic nightclub in Madrid with a vibrant atmosphere.', NULL, NULL, 3),
(20, '{\"lat\": 39.4699, \"lng\": -0.3763}', 'https://media.traveler.es/photos/64ccab5881fcfac4992f9db4/master/w_1600%2Cc_limit/C8J2KG.jpg', 20, '22:30 - 03:30', 'Mya Valencia', '+34 987 654 321', 'Trendy nightclub in Valencia with great music and ambiance.', NULL, NULL, 10),
(21, '{\"lat\": 43.2630, \"lng\": -2.9350}', 'https://www.spain.info/.content/imagenes/rutas/bilbao-dos-dias/bilbao-mercado-ribera-s410197552.jpg', 18, '21:00 - 04:00', 'Fever', '+34 111 222 333', 'Popular nightclub in Bilbao offering a diverse music selection.', NULL, NULL, 4),
(22, '{\"lat\": 37.1773, \"lng\": -3.5986}', 'https://i.blogs.es/5b005c/gastroguia-de-granada-que-comer-en-la-ciudad-de-la-alhambra-y-que-restaurantes-no-perderte/1366_2000.jpg', 20, '22:00 - 04:00', 'Granada 10', '+34 444 555 666', 'Energetic nightclub in Granada known for its lively atmosphere.', NULL, NULL, 11),
(23, '{\"lat\": 41.6488, \"lng\": -0.8891}', 'https://images4.alphacoders.com/704/704363.jpg', 19, '20:30 - 03:30', 'Kenbo', '+34 777 888 999', 'Intimate nightclub in Zaragoza with a unique vibe and great music.', NULL, NULL, 2),
(24, '{\"lat\": 39.8628, \"lng\": -4.0273}', 'https://www.turismociudadreal.com/ARCHIVO/fotografias/conoce/molinos-alcazar-de-san-juan.jpg', 21, '23:30 - 04:30', 'Roca\'s', '+34 123 456 789', 'Chic nightclub in Ciudad Real known for its upscale ambiance.', NULL, NULL, 31),
(25, '{\"lat\": 36.7213, \"lng\": -4.4213}', 'https://content.r9cdn.net/rimg/dimg/ee/b1/8afb451d-city-5309-15cef627e8c.jpg?width=1366&height=768&xhint=1741&yhint=1162&crop=true', 20, '22:00 - 03:00', 'Sala Gold Malaga', '+34 987 654 321', 'Modern nightclub in Malaga offering a diverse range of music.', NULL, NULL, 12),
(26, '{\"lat\": 42.8125, \"lng\": -1.6458}', 'https://www.spain.info/.content/imagenes/cabeceras-grandes/navarra/plaza-castillo-pamplona-c-DeymosHR-s113082760.jpg', 18, '21:00 - 04:00', 'Indara Pamplona', '+34 111 222 333', 'Pamplona\'s hotspot for electronic music and live performances.', NULL, NULL, 19),
(27, '{\"lat\": 37.8882, \"lng\": -4.7794}', 'https://www.spain.info/.content/imagenes/cabeceras-grandes/andalucia/vista-exterior-mezquita-catedral-de-cordoba-s_572068267.jpg', 20, '22:00 - 04:00', 'Mae West Cordoba', '+34 444 555 666', 'Cordoba\'s premier nightclub with a mix of music genres.', NULL, NULL, 8),
(28, '{\"lat\": 39.8528, \"lng\": -4.0240}', 'https://www.leyendasdetoledo.com/wp-content/uploads/2017/09/atardecer-toledo-opt.jpg', 19, '20:30 - 02:30', 'Sithon\'s', '+34 777 888 999', 'Toledo\'s classic nightclub offering a unique medieval ambiance.', NULL, NULL, 17),
(29, '{\"lat\": 41.3879, \"lng\": 2.1699}', 'https://imagenes.20minutos.es/files/image_1920_1080/uploads/imagenes/2023/07/14/basilica-de-la-sagrada-familia.jpeg', 20, '22:00 - 04:00', 'Sala Apolo Barcelona', '+34 123 456 789', 'Barcelona\'s iconic venue for live music and electronic beats.', NULL, NULL, 1),
(30, '{\"lat\": 37.9848, \"lng\": -1.1306}', 'https://www.doyouspain.com/blog/wp-content/uploads/2022/10/MURCIA1.jpg', 21, '23:00 - 04:00', 'Teatre Murcia', '+34 987 654 321', 'Murcia\'s premier theater-themed nightclub with a lively crowd.', NULL, NULL, 16),
(31, '{\"lat\": 28.0997, \"lng\": -15.4134}', 'https://fotografias.lasexta.com/clipping/cmsimages02/2022/06/20/C077ED4B-B40B-4A48-9B06-5F360F97802A/amanecer-teide_98.jpg?crop=2035,1145,x0,y64&width=1900&height=1069&optimize=low&format=webply', 20, '22:30 - 03:30', 'Papagallo beach club', '+34 111 222 333', 'Beachfront nightclub in the Canary Islands with stunning views.', NULL, NULL, 32),
(32, '{\"lat\": 39.4702, \"lng\": -0.3768}', 'https://multimedia.comunitatvalenciana.com/652B914782FF445A8262322F81948572/img/E0A3988242184602BF21D9A5FC04FC74/CV_-_Imagenes_Content_-_1920x1080.jpg?responsive', 18, '21:00 - 03:00', 'Mambo', '+34 444 555 666', 'Valencia\'s famous open-air nightclub with a lively atmosphere.', NULL, NULL, 33),
(33, '{\"lat\": 41.6510, \"lng\": -0.8829}', 'https://www.clara.es/medio/2023/08/30/pueblos-bonitos-de-huesca_39dd9a24_230830191609_1280x720.jpg', 20, '22:00 - 04:00', 'Florida 135', '+34 777 888 999', 'Huesca\'s electronic music haven with a vibrant and diverse crowd.', NULL, NULL, 6),
(34, '{\"lat\": 39.9864, \"lng\": -0.0513}', 'https://www.spain.info/.content/imagenes/cabeceras-grandes/galicia/PN-islas-atlanticas-islas-cies-001-c-Pedro-Giraldez.jpg', 19, '20:30 - 03:30', 'La isla', '+34 123 456 789', 'Galician nightclub with a beachy vibe and a mix of music genres.', NULL, NULL, 7),
(35, '{\"lat\": 40.2575, \"lng\": -3.8231}', 'https://www.avantservicios.com/wp-content/uploads/2017/03/elretiro_madrid_avantservicios.jpg', 21, '23:00 - 04:00', 'Fabrik', '+34 987 654 321', 'Madrid\'s renowned electronic music club with top-notch sound systems.', NULL, NULL, 3),
(36, '{\"lat\": 41.3851, \"lng\": 2.1734}', 'https://ricardobofill.com/wp-content/uploads/2016/03/W_Barcelona_Hotel_Ricardo_Bofill_Taller_Arquitectura_Barcelona_Spain_01.jpg', 20, '23:00 - 05:00', 'Pacha Barcelona', '+34 444 555 666', 'Barcelona\'s iconic nightclub with a luxurious atmosphere and top DJs.', NULL, NULL, 1),
(37, '{\"lat\": 37.8882, \"lng\": -4.7794}', 'https://wordpress-network.prod.aws.skyscnr.com/wp-content/uploads/2018/05/spain-balearic-islands-ibiza-es-vedra-island-490972330.jpg', 19, '20:00 - 03:00', 'Amnesia', '+34 777 888 999', 'Famous nightclub in Ibiza known for its lively parties and international DJs.', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2024_02_01_120237_create_discotecas_table', 1),
(13, '2024_02_05_092427_create_usuarios_table', 1),
(14, '2024_02_16_081313_create_reviews_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `disco_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `puntuacion` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `usuario_id`, `disco_id`, `titulo`, `content`, `photo`, `puntuacion`, `created_at`, `updated_at`) VALUES
(4, 1, 33, 'sdsdsd', 'daadad', 'photos/isiwd0ctqoNaU04ZDcuW6x1BhIl7Vci4zTAC3O9q.jpg', 4, '2024-02-16 14:19:56', '2024-02-16 14:19:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `phone`, `birthdate`, `created_at`, `updated_at`) VALUES
(1, 'asd', 'asd@gmail.com', '$2y$12$o91C4/izstKjykO8TDqsCOM1ZhiTUxuqYBtIKFhc/fZGEXXmuWSnW', '123123123', '2024-01-30', '2024-02-16 08:05:56', '2024-02-16 08:05:56'),
(3, 'CREAAADO', 'CREAAADO@gmail.com', '$2y$12$z/KO8q.a2cmVAxXcg7E7leirrRny4TSMu9NXIDOhiFyZ.DbXMnisS', '888888888', '2024-02-09', '2024-02-16 08:33:45', '2024-02-16 08:33:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `discotecas`
--
ALTER TABLE `discotecas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_usuario_id_foreign` (`usuario_id`),
  ADD KEY `reviews_disco_id_foreign` (`disco_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_nombre_unique` (`nombre`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `discotecas`
--
ALTER TABLE `discotecas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `discotecas`
--
ALTER TABLE `discotecas`
  ADD CONSTRAINT `discotecas_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id`);

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_disco_id_foreign` FOREIGN KEY (`disco_id`) REFERENCES `discotecas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
