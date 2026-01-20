/**
 * Fanartikel Online-Konfigurator
 * Basiert auf Fabric.js
 */

document.addEventListener('DOMContentLoaded', function () {
    const canvasElement = document.getElementById('product-canvas');
    if (!canvasElement) return;

    // Canvas Initialisierung
    const canvas = new fabric.Canvas('product-canvas', {
        width: 500,
        height: 500,
        backgroundColor: 'transparent'
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
    });

    // Globaler Zugriff für Debugging/Erweiterungen
    window.productCanvas = canvas;

    // Text hinzufügen Funktion
    window.addTextToProduct = function (text = 'Dein Text') {
        const color = document.getElementById('text-color-picker').value || '#ffffff';
        const fontFamily = document.getElementById('text-font-family').value || 'Inter';

        const textObj = new fabric.IText(text, {
            left: 250,
            top: 250,
            fontFamily: fontFamily,
            fontSize: 40,
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
                img.scaleToWidth(150);
                img.set({
                    left: 250,
                    top: 250,
                    originX: 'center',
                    originY: 'center'
                });
                canvas.add(img);
                canvas.setActiveObject(img);
            });
        };
        reader.readAsDataURL(file);
    };

    // Export Funktion (für später)
    window.exportProductDesign = function () {
        return canvas.toJSON();
    };

    // Hilfsfunktionen: Löschen
    window.removeSelectedObject = function () {
        const activeObjects = canvas.getActiveObjects();
        if (activeObjects.length > 0) {
            canvas.discardActiveObject();
            activeObjects.forEach((obj) => {
                canvas.remove(obj);
            });
            canvas.renderAll();
        }
    };

    window.clearCanvas = function () {
        if (confirm('Möchtest du wirklich das gesamte Design löschen?')) {
            canvas.getObjects().forEach((obj) => {
                if (obj !== canvas.backgroundImage) {
                    canvas.remove(obj);
                }
            });
            canvas.renderAll();
        }
    };
});
