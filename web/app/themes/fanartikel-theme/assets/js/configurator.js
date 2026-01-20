/**
 * Fanartikel Online-Konfigurator
 * Basiert auf Fabric.js
 */

// Globale Funktionen für das Modal (müssen sofort verfügbar sein)
window.openConfiguratorModal = function () {
    const modal = document.getElementById('configurator-modal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Fabric.js Canvas-Offset aktualisieren, falls initialisiert
        if (window.productCanvas) {
            window.productCanvas.calcOffset();
        }
    } else {
        console.error('Configurator Modal nicht gefunden!');
    }
};

window.closeConfiguratorModal = function () {
    const modal = document.getElementById('configurator-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const canvasElement = document.getElementById('product-canvas');
    if (!canvasElement) return;

    // Konstanten für die Skalierung (in mm)
    const BALL_SIZE_MM = 80;
    const PRINT_AREA_MM = 45;
    const CANVAS_SIZE = 500;

    // Feinjustierung basierend auf dem Mockup Bild (Festliche Szene)
    const BALL_DIAMETER_PX = 310;
    const CENTER_X = 250;
    const CENTER_Y = 265;

    // Canvas Initialisierung
    const canvas = new fabric.Canvas('product-canvas', {
        width: CANVAS_SIZE,
        height: CANVAS_SIZE,
        backgroundColor: 'transparent'
    });

    // Globaler Zugriff
    window.productCanvas = canvas;

    // Clipping Bereich Objekt
    const printAreaPx = (PRINT_AREA_MM / BALL_SIZE_MM) * BALL_DIAMETER_PX;
    const clipCircle = new fabric.Circle({
        radius: printAreaPx / 2,
        left: CENTER_X,
        top: CENTER_Y,
        originX: 'center',
        originY: 'center',
        absolutePositioned: true
    });

    // Mockup Hintergrund laden
    fabric.Image.fromURL(fanartikelConfig.mockupUrl, function (img) {
        img.set({
            selectable: false,
            evented: false,
            scaleX: canvas.width / img.width,
            scaleY: canvas.height / img.height
        });
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

        // Kugel-Overlay für dynamische Färbung erstellen
        fabric.Image.fromURL(fanartikelConfig.mockupUrl, function (overlay) {
            overlay.set({
                selectable: false,
                evented: false,
                scaleX: canvas.width / overlay.width,
                scaleY: canvas.height / overlay.height,
                clipPath: new fabric.Circle({
                    radius: BALL_DIAMETER_PX / 2,
                    left: CENTER_X,
                    top: CENTER_Y,
                    originX: 'center',
                    originY: 'center',
                    absolutePositioned: true
                })
            });

            // Initial-Farbe (Grün)
            window.ballOverlay = overlay;
            canvas.add(overlay);
            // Das Overlay muss hinter dem Guide und den Designs liegen
            overlay.moveTo(0);

            // Initial keine Filter, da das Bild schon grün ist
            // Aber wir bereiten setBallColor vor
        });
    });

    // Hilfslinie
    const guideCircle = new fabric.Circle({
        radius: printAreaPx / 2,
        left: CENTER_X,
        top: CENTER_Y,
        originX: 'center',
        originY: 'center',
        fill: 'transparent',
        stroke: 'rgba(255,255,255,0.4)',
        strokeDashArray: [5, 5],
        selectable: false,
        evented: false
    });
    canvas.add(guideCircle);

    // Ball Farbe ändern
    window.setBallColor = function (hex) {
        if (!window.ballOverlay) return;

        // Swatches UI Update
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        const activeSwatch = Array.from(document.querySelectorAll('.color-swatch')).find(s => s.style.backgroundColor === hex || s.getAttribute('style').includes(hex));
        if (activeSwatch) activeSwatch.classList.add('active');

        // Filter anwenden
        // Wir nutzen BlendColor mit 'multiply' oder 'tint'
        // 'tint' ist oft besser für Seidenmatt-Oberflächen
        window.ballOverlay.filters = [
            new fabric.Image.filters.BlendColor({
                color: hex,
                mode: 'tint',
                alpha: 0.6 // Transparenz anpassen, damit Lichter erhalten bleiben
            })
        ];
        window.ballOverlay.applyFilters();
        canvas.renderAll();
    };

    // Text hinzufügen
    window.addTextToProduct = function (text = 'Dein Text') {
        const color = document.getElementById('text-color-picker').value || '#ffffff';
        const fontFamily = document.getElementById('text-font-family').value || 'Inter';

        const textObj = new fabric.IText(text, {
            left: CENTER_X,
            top: CENTER_Y,
            fontFamily: fontFamily,
            fontSize: 30,
            fill: color,
            originX: 'center',
            originY: 'center',
            clipPath: clipCircle
        });
        canvas.add(textObj);
        canvas.setActiveObject(textObj);
    };

    // Filter-Updates für Logos und Text
    document.getElementById('text-color-picker').addEventListener('input', function (e) {
        const activeObject = canvas.getActiveObject();
        if (!activeObject) return;
        const color = e.target.value;

        if (activeObject.type === 'i-text') {
            activeObject.set('fill', color);
        } else if (activeObject.type === 'image' && activeObject !== canvas.backgroundImage) {
            activeObject.filters = [
                new fabric.Image.filters.RemoveColor({ color: '#FFFFFF', distance: 0.1 }),
                new fabric.Image.filters.BlendColor({ color: color, mode: 'tint', alpha: 1 })
            ];
            activeObject.applyFilters();
        }
        canvas.renderAll();
    });

    document.getElementById('text-font-family').addEventListener('change', function (e) {
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'i-text') {
            activeObject.set('fontFamily', e.target.value);
            canvas.renderAll();
        }
    });

    // Bild-Upload (Logo)
    window.uploadImageToProduct = function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (f) {
            fabric.Image.fromURL(f.target.result, function (img) {
                const color = document.getElementById('text-color-picker').value || '#ffffff';
                img.filters = [
                    new fabric.Image.filters.RemoveColor({ color: '#FFFFFF', distance: 0.1 }),
                    new fabric.Image.filters.BlendColor({ color: color, mode: 'tint', alpha: 1 })
                ];
                img.applyFilters();
                img.scaleToWidth(100);
                img.set({
                    left: CENTER_X,
                    top: CENTER_Y,
                    originX: 'center',
                    originY: 'center',
                    clipPath: clipCircle
                });
                canvas.add(img);
                canvas.setActiveObject(img);
            });
        };
        reader.readAsDataURL(file);
    };

    // Hilfsfunktionen
    window.removeSelectedObject = function () {
        const activeObjects = canvas.getActiveObjects();
        if (activeObjects.length > 0) {
            canvas.discardActiveObject();
            activeObjects.forEach(obj => { if (obj !== guideCircle) canvas.remove(obj); });
            canvas.renderAll();
        }
    };

    window.clearCanvas = function () {
        if (confirm('Design löschen?')) {
            canvas.getObjects().forEach(obj => {
                if (obj !== canvas.backgroundImage && obj !== guideCircle) canvas.remove(obj);
            });
            canvas.renderAll();
        }
    };

    // Klick auf Overlay zum Schließen
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('configurator-modal');
        if (e.target === modal) closeConfiguratorModal();
    });
});
