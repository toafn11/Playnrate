USE playnrate;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `logs`;
TRUNCATE TABLE `ratings`;
TRUNCATE TABLE `game_platforms`;
TRUNCATE TABLE `games`;
TRUNCATE TABLE `platforms`;
TRUNCATE TABLE `genres`;
TRUNCATE TABLE `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Insert Genres
INSERT INTO `genres` (`id`, `name`, `description`) VALUES
(1, 'RPG', 'Role-Playing Games offer deep story and character progression.'),
(2, 'Action', 'Fast-paced combat and reflex-testing gameplay.'),
(3, 'Adventure', 'Exploration and puzzle-solving in rich worlds.'),
(4, 'Simulation', 'Realistic simulations of sports, life, and management.'),
(5, 'Indie', 'Unique and innovative games from independent developers.'),
(6, 'Sports', 'Competitive sports and team management games.'),
(7, 'Strategy', 'Tactical thinking and long-term planning.'),
(8, 'Shooter', 'Focus on weapon-based combat, usually in first or third person.'),
(9, 'Platformer', 'Jumping and navigating through complex environments.'),
(10, 'Horror', 'Survival and psychological scares.');

-- 2. Insert Platforms
INSERT INTO `platforms` (`id`, `name`) VALUES
(1, 'PC'), (2, 'PlayStation 5'), (3, 'PlayStation 4'), 
(4, 'Xbox Series X/S'), (5, 'Xbox One'), (6, 'Nintendo Switch');

-- 3. Insert Users (Admin: iam@dmin, Users: pwd@username)
INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$12$u3sNcgQ4Kog8lVuQ8C78d.T6O9Meh4YGSpAY1VCrb5KPZ4zR4038u', 'admin'),
(2, 'minh', '$2y$12$N8HlF90BD9TfMTBl8BDcbO6dl2ZmB.0N5YdEjtZLdyeXABFDC2Gyu', 'user'),
(3, 'toan', '$2y$12$mE8hirDF282u2yvPWCS8Te8eXIiMOM7Bev2OGn2HFnNRAXT92Ixfq', 'user'),
(4, 'thinh', '$2y$12$7UwMO/DGnjcVk1v5qcYDM.nurznwsJraBdfDVFqV5R6uVgdUxxqVa', 'user'),
(5, 'khoi', '$2y$12$NQEu0C0JWJERoLGmVQtnsuIURkPBN0NHJ2rOd5GjXvpR4OcvsnWFe', 'user'),
(6, 'ha', '$2y$12$.G/UmSooyzUVg4q40QwqNeQg1haG6vMgN/jfZvONKuFLsEUU8Gh9S', 'user'),
(7, 'anh', '$2y$12$RwLMukk5a8cEePF1MK375u4M1hSz7PjYY6d.5HSujNE1UWUg571JS', 'user'),
(8, 'kien', '$2y$12$v.cp06Hr8mC985/8vV2RhugnSWjZ52QmWLsVBOpypPsmuKUiNOutW', 'user'),
(9, 'dat', '$2y$12$z7YQGkF1VseL7RtSbM8P0.eaPY494EibmbajQllCbq15tnX6x5kWG', 'user'),
(10, 'quoc', '$2y$12$71jb/2M1rYVLViablffA9uhIeSzGqSukbIG8/Q6p2F7085pHLwMVS', 'user');

-- 4. Insert Games (32 titles)
INSERT INTO `games` (`id`, `title`, `description`, `genre_id`, `release_year`, `developer`, `publisher`, `cover_image`, `avg_rating`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 'Baldur\'s Gate 3', 'Set in the Dungeons & Dragons universe, this RPG masterpiece offers a rich epic story with almost limitless freedom of choice. Every decision can completely change the world.', 1, '2023', 'Larian Studios', 'Larian Studios', 'cover_69dcc45fa1ced5.86528753.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:24:31'),
(2, 'Monster Hunter: World', 'Become a seasoned hunter, explore a vibrant ecosystem, and engage in breathtaking battles with giant monsters. Utilize skills, diverse weapons, and teamwork to survive.', 2, '2018', 'Capcom', 'Capcom', 'cover_69dcc2dfda4137.94593919.webp', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:18:07'),
(3, 'Monster Hunter Rise', 'Experience the next generation of monster hunting with Wirebug technology offering unprecedented mobility. Soar through the air and fight alongside your new Palamute companion.', 2, '2021', 'Capcom', 'Capcom', 'cover_69dcc32946c7b4.59176861.png', 9.0, 2, '2026-04-13 08:53:58', '2026-04-13 10:19:21'),
(4, 'Football Manager 2024', 'The most detailed football management simulation ever. Take control of a club, from buying players and developing young talent to crafting tactics for intense matches.', 4, '2023', 'Sports Interactive', 'SEGA', 'cover_69dcc33d2f45d0.28220449.jpg', 8.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:19:41'),
(5, 'Cult of the Lamb', 'Start your own cult in a world of false prophets. Build a community of loyal followers, gather resources, and perform dark rituals to become the one true god.', 5, '2022', 'Massive Monster', 'Devolver Digital', 'cover_69dcc350a5a0c8.13633783.jpg', 8.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:20:00'),
(6, 'The Witcher 3: Wild Hunt', 'Play as Geralt of Rivia, a professional monster hunter. Explore a massive, war-torn continent and face morally ambiguous choices while searching for the Child of Prophecy.', 1, '2015', 'CD Projekt Red', 'CD Projekt', 'cover_69dcc36f1257a9.51344091.webp', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:20:31'),
(7, 'Cyberpunk 2077', 'Night City is a megalopolis obsessed with power, glamour, and body modification. Play as V, a mercenary outlaw going after a one-of-a-kind implant that is the key to immortality.', 1, '2020', 'CD Projekt Red', 'CD Projekt', 'cover_69dcc48e784614.32188514.jpg', 8.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:25:18'),
(8, 'Red Dead Redemption 2', 'An epic tale of life in America\'s unforgiving heartland. Follow Arthur Morgan and the Van der Linde gang as they rob, steal, and fight their way across the rugged terrain.', 3, '2018', 'Rockstar Games', 'Rockstar Games', 'cover_69dcc4acad12c6.56419780.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:25:48'),
(9, 'Elden Ring', 'An action-RPG masterpiece blending the brutal challenge of Dark Souls with a vast open world co-created by Hidetaka Miyazaki and George R. R. Martin. Rise and become the Elden Lord.', 1, '2022', 'FromSoftware', 'Bandai Namco', 'cover_69dcc4c9f13132.10139818.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:26:17'),
(10, 'Grand Theft Auto V', 'Three distinct criminals – Michael, Franklin, and Trevor – team up to pull off a series of dangerous heists in Los Santos in Rockstar\'s greatest open-world action game.', 2, '2013', 'Rockstar North', 'Rockstar Games', 'cover_69dcc3cfa3d5a1.32265730.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:22:07'),
(11, 'The Legend of Zelda: Breath of the Wild', 'Awakening after a century, Link must explore a vast and wild Hyrule. This game redefined the open-world genre by encouraging curiosity and creativity in every interaction.', 3, '2017', 'Nintendo EPD', 'Nintendo', 'cover_69dcc3f7c04d19.41200576.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:22:47'),
(12, 'The Legend of Zelda: Tears of the Kingdom', 'The sequel to Breath of the Wild adds new powers like Ultrahand, allowing Link to craft vehicles and flying machines to explore both the vast lands and mysterious sky islands.', 3, '2023', 'Nintendo EPD', 'Nintendo', 'cover_69dcc4ec22d6f2.32060325.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:26:52'),
(13, 'God of War', 'Leaving his bloody past behind, Kratos lives as a man in the harsh realm of Norse gods and monsters. Together with his son Atreus, he must fight to fulfill his wife\'s final wish.', 2, '2018', 'Santa Monica Studio', 'Sony Interactive', 'cover_69dcc51210c0a2.10119598.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:27:30'),
(14, 'God of War Ragnarök', 'Fimbulwinter is drawing to a close. Kratos and Atreus must journey to each of the Nine Realms in search of answers before Ragnarök destroys the world.', 2, '2022', 'Santa Monica Studio', 'Sony Interactive', 'cover_69dcc53939c1a8.09669177.webp', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:28:09'),
(15, 'Ghost of Tsushima', 'In the late 13th century, the Mongol empire ravages Tsushima. Play as Jin Sakai, a samurai who must cast aside traditions to become the Ghost and free his homeland.', 2, '2020', 'Sucker Punch', 'Sony Interactive', 'cover_69dcc556909d68.51844038.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:28:38'),
(16, 'Marvel\'s Spider-Man Remastered', 'Swing through a vibrant New York City, battle iconic villains, and balance Peter Parker\'s chaotic personal life with the heavy responsibilities of being Spider-Man.', 2, '2018', 'Insomniac Games', 'Sony Interactive', 'cover_69dcc57d368907.35372691.jpg', 8.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:29:17'),
(17, 'Hollow Knight', 'A classic Metroidvania that takes you deep into the ruined insect kingdom of Hallownest. Explore caverns, battle tainted creatures, and solve mysteries in a beautifully hand-drawn world.', 9, '2017', 'Team Cherry', 'Team Cherry', 'cover_69dcc5acc53d11.76133558.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:30:04'),
(18, 'Hades', 'Play as Zagreus, the Prince of the Underworld, in a blood-pumping effort to escape his father\'s domain. A rogue-like with incredibly smooth combat where every death makes you stronger.', 5, '2020', 'Supergiant Games', 'Supergiant Games', 'cover_69dcc5c6137286.35718169.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:30:30'),
(19, 'Celeste', 'Help Madeline survive her inner demons on her journey to the top of Celeste Mountain. A super-tight, handcrafted platformer with a touching story of self-discovery.', 9, '2018', 'Extremely OK Games', 'Extremely OK Games', 'cover_69dcc5f25d83b6.20334715.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:31:14'),
(20, 'Stardew Valley', 'You\'ve inherited your grandfather\'s old farm plot. Armed with hand-me-down tools and a few coins, you set out to begin your new life in this incredibly addictive farming simulator.', 4, '2016', 'ConcernedApe', 'ConcernedApe', 'cover_69dcc60927e6f1.66249133.png', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:31:37'),
(21, 'Terraria', 'Dig, fight, explore, build! Nothing is impossible in this action-packed adventure game. The world is your canvas and the ground itself is your paint.', 5, '2011', 'Re-Logic', '505 Games', 'cover_69dcc62c1b3225.72276889.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:32:12'),
(22, 'Minecraft', 'The legendary sandbox game that changed the industry forever. Craft tools, build shelters, survive the night, and explore endless blocky landscapes.', 3, '2011', 'Mojang', 'Microsoft', 'cover_69dcc649177384.06656770.png', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:32:41'),
(23, 'Doom Eternal', 'Become the Doom Slayer and rip and tear across dimensions to stop the final destruction of humanity. Fast-paced push-forward combat powered by an incredible heavy metal soundtrack.', 8, '2020', 'id Software', 'Bethesda', 'cover_69dcc6665123f4.56772916.png', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:33:10'),
(24, 'Forza Horizon 5', 'Explore the vibrant and ever-evolving open-world landscapes of Mexico with limitless, fun driving action in hundreds of the world\'s greatest cars.', 6, '2021', 'Playground Games', 'Xbox Game Studios', 'cover_69dcc6993f0294.59813758.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:34:01'),
(25, 'FIFA 24 (FC 24)', 'Experience the most authentic football simulation with HyperMotionV technology. Build your dream squad in Ultimate Team or manage your favorite club to glory.', 6, '2023', 'EA Sports', 'Electronic Arts', 'cover_69dcc6bade7085.49099350.jpg', 7.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:34:34'),
(26, 'Sekiro: Shadows Die Twice', 'Carve your own clever path to vengeance in this award-winning adventure. Master the art of parrying in brutal but immensely satisfying sword combat.', 2, '2019', 'FromSoftware', 'Activision', 'cover_69dcc6e6855887.00642439.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:35:18'),
(27, 'Bloodborne', 'Travel to the city of Yharnam, cursed with a strange endemic illness spreading through the streets like wildfire. A dark, Lovecraftian masterpiece with aggressive combat.', 1, '2015', 'FromSoftware', 'Sony Interactive', 'cover_69dcc6fe7826b5.38867825.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:35:42'),
(28, 'Resident Evil 4 Remake', 'Survival is just the beginning. Agent Leon S. Kennedy is sent to a remote European village to rescue the President\'s kidnapped daughter in this masterful remake.', 10, '2023', 'Capcom', 'Capcom', 'cover_69dcc71d41fff2.15599081.webp', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:36:13'),
(29, 'The Last of Us Part I', 'In a ravaged civilization, where infected and hardened survivors run rampant, Joel is hired to smuggle a 14-year-old girl, Ellie, out of an oppressive quarantine zone.', 3, '2013', 'Naughty Dog', 'Sony Interactive', 'cover_69dcc736a8c609.73388577.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:36:38'),
(30, 'The Last of Us Part II', 'Experience the escalating moral conflicts created by Ellie\'s relentless pursuit of vengeance. The cycle of violence left in her wake will challenge your notions of right and wrong.', 2, '2020', 'Naughty Dog', 'Sony Interactive', 'cover_69dcc74b724ac4.95194162.png', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:36:59'),
(31, 'Dark Souls III', 'As fires fade and the world falls into ruin, journey into a universe filled with more colossal enemies and environments. The pinnacle of punishing action-RPG gameplay.', 1, '2016', 'FromSoftware', 'Bandai Namco', 'cover_69dcc761c77ab7.69245162.jpg', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:37:21'),
(32, 'Final Fantasy VII Remake', 'A spectacular reimagining of one of the most visionary games ever, featuring a hybrid battle system that merges real-time action with strategic, command-based combat.', 1, '2020', 'Square Enix', 'Square Enix', 'cover_69dcc7754a62b8.27215386.png', 9.0, 1, '2026-04-13 08:53:58', '2026-04-13 10:37:41');


-- 5. Game Platforms mapping
INSERT INTO `game_platforms` (`game_id`, `platform_id`) VALUES
(1, 1), (1, 2), (2, 1), (2, 4), (3, 1), (3, 6), (4, 1), (5, 1), (6, 1), (6, 2), (7, 1), (8, 1), (9, 1), (10, 1), (11, 6), (12, 6), (13, 1), (13, 2), (14, 2), (15, 2), (16, 2), (17, 1), (18, 1), (19, 1), (20, 1), (21, 1), (22, 1), (23, 1), (24, 1), (25, 1), (26, 1), (27, 3), (28, 1), (29, 2), (30, 3), (31, 1), (32, 2);

-- 6. Insert Ratings (2 per game, 64 total)
INSERT INTO `ratings` (`game_id`, `user_id`, `score`, `review_text`) VALUES
(1, 2, 9, 'An incredible masterpiece of storytelling and player agency.'),
(1, 3, 9, 'Best RPG I have played in years. Highly recommended!'),
(2, 4, 10, 'Satisfying combat loop and amazing creature designs.'),
(2, 5, 9, 'Perfect for playing with friends. Very addictive.'),
(3, 6, 9, 'Smooth gameplay and fast-paced action. Great addition to the series.'),
(3, 7, 9, 'Love the mobility mechanics and the new monsters.'),
(4, 8, 8, 'Unparalleled depth in management. A must-buy for tactical fans.'),
(4, 9, 9, 'I can''t stop playing. Just one more match!'),
(5, 10, 8, 'Unique blend of base-building and rogue-like combat.'),
(5, 2, 9, 'Dark, funny, and very polished. Great indie title.'),
(6, 3, 10, 'The standard for open-world RPGs. Breathtaking world.'),
(6, 4, 9, 'Strong characters and meaningful side quests.'),
(7, 5, 8, 'Night City is beautiful and the story is gripping.'),
(7, 6, 8, 'Much improved since launch. A great sci-fi experience.'),
(8, 7, 9, 'Slow-paced but incredibly immersive. A technical marvel.'),
(8, 8, 9, 'Emotional story and top-tier world building.'),
(9, 9, 9, 'Hard but fair. The sense of discovery is unmatched.'),
(9, 10, 9, 'FromSoftware has perfected the formula here.'),
(10, 2, 10, 'A timeless classic. Still fun after all these years.'),
(10, 3, 9, 'Vast world with so much to do. Great heist missions.'),
(11, 4, 10, 'Pure exploration at its finest. Changed the genre.'),
(11, 5, 9, 'Hyrule is a joy to traverse. Endless secrets.'),
(12, 6, 10, 'Took everything great about the first game and expanded it.'),
(12, 7, 10, 'Creative building mechanics make this feel brand new.'),
(13, 8, 10, 'Fantastic father-son dynamic and brutal combat.'),
(13, 9, 9, 'Visuals are stunning and the story is very personal.'),
(14, 10, 10, 'Epic conclusion to the Norse saga. Emotional journey.'),
(14, 2, 9, 'The best combat system in any action game right now.'),
(15, 3, 9, 'Visual style is unparalleled. Every frame is a painting.'),
(15, 4, 9, 'Satisfying samurai combat and great atmosphere.'),
(16, 5, 8, 'Best web-swinging ever. Makes you feel like Spider-Man.'),
(16, 6, 9, 'Great story that rivals the movies. Very polished.'),
(17, 7, 9, 'Tough platforming and beautiful atmosphere. A masterpiece.'),
(17, 8, 9, 'The world of Hallownest is hauntingly beautiful.'),
(18, 9, 10, 'Perfectly balanced rogue-like. Story is woven in expertly.'),
(18, 10, 9, 'Fast combat and great voice acting. Hard to put down.'),
(19, 2, 9, 'Emotional story about mental health and tough platforming.'),
(19, 3, 9, 'Controls are perfect. Very rewarding challenge.'),
(20, 4, 9, 'Relaxing and wholesome. The perfect cozy game.'),
(20, 5, 9, 'Incredible depth for a one-man project.'),
(21, 6, 9, 'Endless creativity and exploration. 2D Minecraft and more.'),
(21, 7, 9, 'Tons of bosses and items to find. Very deep systems.'),
(22, 8, 10, 'Infinite possibilities. The ultimate creative tool.'),
(22, 9, 9, 'Survival mode is still a blast after all this time.'),
(23, 10, 9, 'Rip and tear until it is done. Pure adrenaline.'),
(23, 2, 9, 'Fastest and most aggressive shooter on the market.'),
(24, 3, 9, 'Best racing game for casual fans. Mexico is stunning.'),
(24, 4, 9, 'Massive car list and great sound design.'),
(25, 5, 7, 'Solid football sim but lacks major innovation.'),
(25, 6, 8, 'Fun with friends, though career mode needs work.'),
(26, 7, 9, 'The rhythm-based combat is incredibly satisfying.'),
(26, 8, 9, 'Hardest FromSoftware game but the most rewarding.'),
(27, 9, 10, 'Hauntingly beautiful world and aggressive combat.'),
(27, 10, 9, 'The atmosphere of Yharnam is unmatched.'),
(28, 2, 9, 'Perfect remake. Keeps the soul of the original alive.'),
(28, 3, 10, 'Incredible visuals and much improved controls.'),
(29, 4, 10, 'One of the best stories ever told in gaming.'),
(29, 5, 9, 'Tense stealth and very emotional character moments.'),
(30, 6, 9, 'Technical masterpiece with a very brave story.'),
(30, 7, 9, 'Combat and animations are industry-leading.'),
(31, 8, 9, 'Beautifully melancholic world and epic boss fights.'),
(31, 9, 10, 'The perfect end to the Dark Souls trilogy.'),
(32, 10, 9, 'Great mix of action and tactical combat.'),
(32, 2, 9, 'Beautifully reimagined Midgar. Can''t wait for the next part.');