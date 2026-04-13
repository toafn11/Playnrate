<?php

$pageTitle = 'Our Development Team';
require_once 'includes/header.php'; ?>

<section class="container" style="margin-top: 4rem; margin-bottom: 5rem;">
    <div style="text-align: center; margin-bottom: 4rem;">
        <h2 class="section-title" style="display: inline-block;">MEET OUR TEAM</h2>
        <p style="color: var(--text-muted); margin-top: 1rem; font-size: 1.1rem;">
            The passionate developers behind the PlayNRate project.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">

        <div class="game-card" style="padding: 2rem; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--accent), var(--accent-h)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 1.5rem; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                👤
            </div>
            <h3 style="color: #fff; margin-bottom: 0.5rem;">NGUYỄN NHỰT MINH</h3>
            <span style="color: var(--accent); font-family: monospace; font-size: 1.2rem; font-weight: bold; letter-spacing: 2px;">B2306674</span>
            <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">Lead Developer & Database Architect</p>
        </div>

        <div class="game-card" style="padding: 2rem; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--accent), var(--accent-h)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 1.5rem; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                👤
            </div>
            <h3 style="color: #fff; margin-bottom: 0.5rem;">QUANG NHỰT MINH</h3>
            <span style="color: var(--accent); font-family: monospace; font-size: 1.2rem; font-weight: bold; letter-spacing: 2px;">B2306675</span>
            <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">Frontend Specialist & UI/UX Designer</p>
        </div>

        <div class="game-card" style="padding: 2rem; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--accent), var(--accent-h)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin-bottom: 1.5rem; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                👤
            </div>
            <h3 style="color: #fff; margin-bottom: 0.5rem;">DƯƠNG TRƯƠNG MINH TOÀN</h3>
            <span style="color: var(--accent); font-family: monospace; font-size: 1.2rem; font-weight: bold; letter-spacing: 2px;">B2306686</span>
            <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">Backend Engineer & Security Expert</p>
        </div>

    </div>

    <div class="form-card" style="margin-top: 5rem; padding: 3rem; background: rgba(255,255,255,0.02); border: 1px solid var(--border);">
        <h3 style="color: #fff; margin-bottom: 2rem; text-align: center;">PROJECT TECHNICAL SPECIFICATIONS</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center;">
            <div style="padding: 1rem; border-right: 1px solid var(--border);">
                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">Server</strong>
                <span style="color: #ecf0f1;">Apache HTTP Server</span>
            </div>
            <div style="padding: 1rem; border-right: 1px solid var(--border);">
                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">Backend</strong>
                <span style="color: #ecf0f1;">PHP 8.2 (Procedural)</span>
            </div>
            <div style="padding: 1rem; border-right: 1px solid var(--border);">
                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">Database</strong>
                <span style="color: #ecf0f1;">MySQL / MariaDB</span>
            </div>
            <div style="padding: 1rem;">
                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">Frontend</strong>
                <span style="color: #ecf0f1;">Modern HTML5 & CSS3</span>
            </div>
        </div>
        <p style="margin-top: 2rem; text-align: center; font-style: italic; color: var(--text-muted); font-size: 0.9rem;">
            This project is developed as part of the Web Programming course at Can Tho University.
        </p>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>