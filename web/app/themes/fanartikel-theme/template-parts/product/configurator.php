<?php
/**
 * Christbaumkugel Konfigurator Template
 */
?>

<div class="product-configurator-container">
    <div class="canvas-wrapper"
        style="position: relative; width: 500px; height: 500px; margin: 0 auto; background: #1a1a1a; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
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
                    <label style="color: #ccc; font-size: 0.8rem;">Farbe:</label>
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

<style>
    .product-configurator-container {
        padding: 2rem;
        background: #111;
        border-radius: 16px;
        margin: 2rem 0;
    }

    .canvas-container {
        margin: 0 auto !important;
    }
</style>