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

    // 1. Hintergrund laden (Statisch)
    fabric.Image.fromURL(fanartikelConfig.backgroundUrl, function (img) {
        img.set({
            selectable: false,
            evented: false,
            scaleX: canvas.width / img.width,
            scaleY: canvas.height / img.height
        });
        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
    });

    // 2. Kugel-Layer initialisieren (Dynamisch)
    window.productLayer = null;

    window.setBallColor = function (hex, filename) {
        const imageUrl = fanartikelConfig.ballsUrlBase + filename;

        // Swatches UI Update
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        const activeSwatch = Array.from(document.querySelectorAll('.color-swatch')).find(s => s.style.backgroundColor === hex || s.getAttribute('style').includes(hex));
        if (activeSwatch) activeSwatch.classList.add('active');

        // Neues Bild laden
        fabric.Image.fromURL(imageUrl, function (img) {
            // Falls bereits ein Layer existiert, entfernen
            if (window.productLayer) {
                canvas.remove(window.productLayer);
            }

            img.set({
                selectable: false,
                evented: false,
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                originX: 'left',
                originY: 'top',
                left: 0,
                top: 0
            });

            window.productLayer = img;
            canvas.add(img);

            // Layer nach ganz hinten verschieben (aber vor das BackgroundImage)
            img.sendToBack();
            canvas.renderAll();
        }, { crossOrigin: 'anonymous' });
    };

    // Initial-Farbe (Grün) laden
    // Hinweis: Falls green.png noch nicht existiert, nutzen wir das alte Bild als Fallback
    setBallColor('#2e7d32', 'green.png');

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

    /**
     * Produkt mit Design in den Warenkorb legen
     */
    window.addToCartWithDesign = function () {
        const button = document.getElementById('add-to-cart-button');
        const quantity = document.getElementById('product-quantity').value || 10;
        const designJson = JSON.stringify(canvas.toJSON());

        // Button-Status ändern
        const originalText = button.innerText;
        button.innerText = 'Wird hinzugefügt...';
        button.disabled = true;

        jQuery.ajax({
            url: fanartikelConfig.ajaxUrl,
            type: 'POST',
            data: {
                action: 'fanartikel_add_to_cart',
                quantity: quantity,
                design_json: designJson,
                product_id: 0 // Wird serverseitig als Fallback ermittelt, falls nicht vorhanden
            },
            success: function (response) {
                if (response.success) {
                    button.innerText = 'Hinzugefügt!';
                    button.style.background = '#4ade80';

                    // Optional: Weiterleitung zum Warenkorb
                    setTimeout(() => {
                        window.location.href = response.data.cart_url;
                    }, 800);
                } else {
                    alert('Fehler: ' + response.data.message);
                    button.innerText = originalText;
                    button.disabled = false;
                }
            },
            error: function () {
                alert('Ein technischer Fehler ist aufgetreten.');
                button.innerText = originalText;
                button.disabled = false;
            }
        });
    };
});
