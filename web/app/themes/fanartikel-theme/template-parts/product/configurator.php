<?php
/**
 * Christbaumkugel Konfigurator Template
 */
?>

<div class="configurator-wrapper d-flex flex-column gap-4">
    <!-- Canvas Area -->
    <div class="canvas-container-outer bg-black rounded shadow-lg overflow-hidden border border-secondary" style="margin: 0 auto; max-width: 500px;">
        <canvas id="product-canvas"></canvas>
    </div>

    <!-- Controls Area -->
    <div class="controls-container p-4 bg-dark rounded border border-secondary text-white shadow">
        <div class="row g-4">
            <!-- Text Input -->
            <div class="col-md-6">
                <h5 class="mb-3 text-uppercase small ls-wide opacity-75">Text Personalisierung</h5>
                <div class="d-flex flex-column gap-3">
                    <input type="text" id="custom-text-input" placeholder="Wunschtext hier..." 
                           class="form-control bg-dark border-secondary text-white py-2 px-3">
                    
                    <div class="d-flex gap-2 align-items-center">
                        <input type="color" id="text-color-picker" value="#ffffff" 
                               class="form-control form-control-color bg-transparent border-0" style="width: 50px;">
                        
                        <select id="text-font-family" class="form-select bg-dark border-secondary text-white">
                            <option value="Inter">Standard Font</option>
                            <option value="Arial">Modern Bold</option>
                            <option value="Times New Roman">Classic Serif</option>
                            <option value="Courier New">Retro Type</option>
                        </select>
                    </div>

                    <button onclick="addTextToProduct(document.getElementById('custom-text-input').value)" 
                            class="btn btn-primary w-100 py-2 fw-bold text-uppercase">
                        Text Hinzufügen
                    </button>
                </div>
            </div>

            <!-- Image Upload & Actions -->
            <div class="col-md-6">
                <h5 class="mb-3 text-uppercase small ls-wide opacity-75">Logo / Grafik</h5>
                <div class="d-flex flex-column gap-3">
                    <input type="file" id="image-upload" accept="image/*" onchange="uploadImageToProduct(event)"
                           class="form-control bg-dark border-secondary text-white">
                    
                    <div class="d-flex gap-2 mt-auto">
                        <button onclick="removeSelectedObject()" class="btn btn-outline-danger flex-grow-1 py-2">
                            Löschen
                        </button>
                        <button onclick="clearCanvas()" class="btn btn-outline-secondary flex-grow-1 py-2">
                            Alles Leeren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .configurator-wrapper canvas {
        display: block;
        max-width: 100%;
        height: auto !important;
    }
    .form-control:focus, .form-select:focus {
        background-color: #222 !important;
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
        color: white;
    }
</style>