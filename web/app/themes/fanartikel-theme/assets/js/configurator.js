/**
 * Fanartikel Online-Konfigurator
 * Basiert auf Fabric.js
 */

document.addEventListener('DOMContentLoaded', function () {
    const canvasElement = document.getElementById('product-canvas');
    if (!canvasElement) return;

    // Konstanten für die Skalierung (in mm)
    const BALL_SIZE_MM = 80;
    const PRINT_AREA_MM = 45;
    const CANVAS_SIZE = 500;

    // Canvas Initialisierung
    const canvas = new fabric.Canvas('product-canvas', {
        width: CANVAS_SIZE,
        height: CANVAS_SIZE,
        backgroundColor: 'transparent'
    });

    // Clipping Bereich berechnen (45/80 des Mockups)
    // Wir nehmen an, dass die Kugel das gesamte 500x500 Canvas füllt (zentriert)
    const printAreaPx = (PRINT_AREA_MM / BALL_SIZE_MM) * CANVAS_SIZE;
    const clipCircle = new fabric.Circle({
        radius: printAreaPx / 2,
        left: CANVAS_SIZE / 2,
        top: CANVAS_SIZE / 2,
        originX: 'center',
        originY: 'center',
        absolutePositioned: true
    });

    canvas.clipPath = clipCircle;

    // Mockup Hintergrund laden
    fabric.Image.fromURL(fanartikelConfig.mockupUrl, function (img) {
        img.set({
            selectable: false,
            evented: false,
            scaleX: canvas.width / img.width,
            scaleY: canvas.height / img.height
        });
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
    });

    // Hilfslinie für den Druckbereich (optional, nur zur Orientierung)
    const guideCircle = new fabric.Circle({
        radius: printAreaPx / 2,
        left: CANVAS_SIZE / 2,
        top: CANVAS_SIZE / 2,
        originX: 'center',
        originY: 'center',
        fill: 'transparent',
        stroke: 'rgba(255,255,255,0.3)',
        strokeDashArray: [5, 5],
        selectable: false,
        evented: false
    });
    canvas.add(guideCircle);

    // Globaler Zugriff für Debugging/Erweiterungen
    window.productCanvas = canvas;

    // Text hinzufügen Funktion
    window.addTextToProduct = function (text = 'Dein Text') {
        const color = document.getElementById('text-color-picker').value || '#ffffff';
        const fontFamily = document.getElementById('text-font-family').value || 'Inter';

        const textObj = new fabric.IText(text, {
            left: CANVAS_SIZE / 2,
            top: CANVAS_SIZE / 2,
            fontFamily: fontFamily,
            fontSize: 30, // Etwas kleinerer Standard
            fill: color,
            originX: 'center',
            originY: 'center'
        });
        canvas.add(textObj);
        canvas.setActiveObject(textObj);
    };

    // Live-Updates für selektierte Objekte
    document.getElementById('text-color-picker').addEventListener('input', function (e) {
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'i-text') {
            activeObject.set('fill', e.target.value);
            canvas.renderAll();
        }
    });

    document.getElementById('text-font-family').addEventListener('change', function (e) {
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'i-text') {
            activeObject.set('fontFamily', e.target.value);
            canvas.renderAll();
        }
    });

    // Bild-Upload Funktion
    window.uploadImageToProduct = function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (f) {
            const data = f.target.result;
            fabric.Image.fromURL(data, function (img) {
                img.scaleToWidth(100); // Standardgröße für den Druckbereich angepasst
                img.set({
                    left: CANVAS_SIZE / 2,
                    top: CANVAS_SIZE / 2,
                    originX: 'center',
                    originY: 'center'
                });
                canvas.add(img);
                canvas.setActiveObject(img);
            });
        };
        reader.readAsDataURL(file);
    };

    // Export Funktion
    window.exportProductDesign = function () {
        // Beim Export wollen wir ggf. die Hilfslinie ausblenden
        guideCircle.visible = false;
        const data = canvas.toDataURL({
            format: 'png',
            quality: 1
        });
        guideCircle.visible = true;
        return data;
    };

    // Hilfsfunktionen: Löschen
    window.removeSelectedObject = function () {
        const activeObjects = canvas.getActiveObjects();
        if (activeObjects.length > 0) {
            canvas.discardActiveObject();
            activeObjects.forEach((obj) => {
                if (obj !== guideCircle) {
                    canvas.remove(obj);
                }
            });
            canvas.renderAll();
        }
    };

    window.clearCanvas = function () {
        if (confirm('Möchtest du wirklich das gesamte Design löschen?')) {
            canvas.getObjects().forEach((obj) => {
                if (obj !== canvas.backgroundImage && obj !== guideCircle) {
                    canvas.remove(obj);
                }
            });
            canvas.renderAll();
        }
    };
});
