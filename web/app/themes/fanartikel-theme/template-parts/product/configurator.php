<?php
/**
 * Christbaumkugel Konfigurator Template
 */
?>

<div id="configurator-modal" class="configurator-modal-overlay" style="display: none;">
    <div class="configurator-modal-content">
        <button class="modal-close" onclick="closeConfiguratorModal()">&times;</button>

        <div class="product-configurator-container">
            <div class="canvas-wrapper"
                style="position: relative; width: 500px; height: 500px; margin: 0 auto; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                <canvas id="product-canvas"></canvas>
            </div>

            <div class="configurator-controls"
                style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <!-- Text Steuerung -->
                <div class="control-group"
                    style="background: #222; padding: 1rem; border-radius: 8px; border: 1px solid #333; flex: 1; min-width: 250px;">
                    <h4 style="margin: 0 0 1rem 0; color: #fff;">Text bearbeiten</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <input type="text" id="custom-text-input" placeholder="Text eingeben..."
                            style="padding: 0.5rem; border-radius: 4px; border: 1px solid #444; background: #333; color: #fff;">

                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <label style="color: #ccc; font-size: 0.8rem;">Druckfarbe (Text & Logo):</label>
                            <input type="color" id="text-color-picker" value="#ffffff"
                                style="border: none; background: none; width: 40px; height: 30px; cursor: pointer;">

                            <label style="color: #ccc; font-size: 0.8rem; margin-left: 0.5rem;">Font:</label>
                            <select id="text-font-family"
                                style="padding: 0.3rem; background: #333; color: #fff; border: 1px solid #444; border-radius: 4px;">
                                <option value="Inter">Standard</option>
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Classic</option>
                                <option value="Courier New">Typewriter</option>
                            </select>
                        </div>

                        <button onclick="addTextToProduct(document.getElementById('custom-text-input').value)"
                            class="button primary"
                            style="background: #2e7d32; color: #fff; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer; font-weight: 600;">Text
                            hinzufügen</button>
                    </div>
                </div>

                <!-- Kugel Farbe -->
                <div class="control-group"
                    style="background: #222; padding: 1rem; border-radius: 8px; border: 1px solid #333; flex: 1; min-width: 250px;">
                    <h4 style="margin: 0 0 1rem 0; color: #fff;">Kugel-Farbe</h4>
                    <div class="color-swatches"
                        style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem;">
                        <?php
                        $ball_colors = [
                            '#2e7d32' => 'Grün',
                            '#c62828' => 'Rot',
                            '#1565c0' => 'Blau',
                            '#f9a825' => 'Gold',
                            '#37474f' => 'Anthrazit',
                            '#f48fb1' => 'Rosa',
                            '#6a1b9a' => 'Lila',
                            '#ef6c00' => 'Orange',
                            '#ffffff' => 'Weiß',
                            '#9e9e9e' => 'Silber',
                            '#000000' => 'Schwarz',
                            '#8d6e63' => 'Kupfer',
                            '#fdd835' => 'Gelb',
                            '#b2ff59' => 'Hellgrün'
                        ];
                        foreach ($ball_colors as $hex => $name): ?>
                            <div class="color-swatch" onclick="setBallColor('<?php echo $hex; ?>')"
                                title="<?php echo $name; ?>"
                                style="width: 25px; height: 25px; border-radius: 50%; background: <?php echo $hex; ?>; cursor: pointer; border: 2px solid #444; transition: transform 0.2s;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Bild Upload -->
                <div class="control-group"
                    style="background: #222; padding: 1rem; border-radius: 8px; border: 1px solid #333; flex: 1; min-width: 250px;">
                    <h4 style="margin: 0 0 1rem 0; color: #fff;">Grafik hochladen</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <input type="file" id="image-upload" accept="image/*" onchange="uploadImageToProduct(event)"
                            style="color: #ccc; font-size: 0.8rem;">
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                            <button onclick="removeSelectedObject()"
                                style="background: #c62828; color: #fff; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; flex: 1; font-size: 0.8rem;">Selektion
                                löschen</button>
                            <button onclick="clearCanvas()"
                                style="background: #444; color: #fff; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; flex: 1; font-size: 0.8rem;">Alles
                                leeren</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .configurator-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        backdrop-filter: blur(8px);
    }

    .configurator-modal-content {
        position: relative;
        background: #111;
        padding: 1rem;
        border-radius: 20px;
        max-width: 900px;
        width: 95%;
        max-height: 95vh;
        overflow-y: auto;
        border: 1px solid #333;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        color: #fff;
        font-size: 2.5rem;
        line-height: 1;
        cursor: pointer;
        z-index: 10;
        transition: transform 0.2s;
    }

    .modal-close:hover {
        transform: scale(1.1);
        color: #2e7d32;
    }

    .product-configurator-container {
        padding: 1rem;
        margin: 0;
        background: transparent;
    }

    .canvas-wrapper {
        max-width: 100%;
        height: auto !important;
    }

    .canvas-container {
        margin: 0 auto !important;
        max-width: 100%;
    }

    .color-swatch:hover {
        transform: scale(1.2);
        border-color: #fff !important;
    }

    .color-swatch.active {
        border-color: #2e7d32 !important;
        box-shadow: 0 0 10px rgba(46, 125, 50, 0.5);
    }
</style>