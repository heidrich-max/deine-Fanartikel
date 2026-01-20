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

    // Feinjustierung basierend auf dem Mockup Bild (Festliche Szene)
    const BALL_DIAMETER_PX = 310; // Präziser Durchmesser der Kugel im Bild
    const CENTER_X = 250; // Horizontal zentriert
    const CENTER_Y = 265; // Vertikal zentriert auf der Kugel (verschoben nach oben)

    // Canvas Initialisierung
    const canvas = new fabric.Canvas('product-canvas', {
        width: CANVAS_SIZE,
        height: CANVAS_SIZE,
        backgroundColor: 'transparent'
    });

    // Clipping Bereich Objekt (45/80 der Kugelgröße)
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
    });

    // Hilfslinie für den Druckbereich
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

    // Globaler Zugriff für Debugging/Erweiterungen
    window.productCanvas = canvas;

    // Text hinzufügen Funktion
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

    // Live-Updates für selektierte Objekte (Text & Logos)
    document.getElementById('text-color-picker').addEventListener('input', function (e) {
        const activeObject = canvas.getActiveObject();
        if (!activeObject) return;

        const color = e.target.value;

        if (activeObject.type === 'i-text') {
            activeObject.set('fill', color);
        } else if (activeObject.type === 'image' && activeObject !== canvas.backgroundImage) {
            // Farbanpassung für monochrome Logos via Filter
            activeObject.filters = [
                new fabric.Image.filters.RemoveColor({
                    color: '#FFFFFF',
                    distance: 0.1
                }),
                new fabric.Image.filters.BlendColor({
                    color: color,
                    mode: 'tint',
                    alpha: 1
                })
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

    // Bild-Upload Funktion (Logo)
    window.uploadImageToProduct = function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (f) {
            const data = f.target.result;
            fabric.Image.fromURL(data, function (img) {
                const color = document.getElementById('text-color-picker').value || '#ffffff';

                // Hintergrund entfernen (Weiß) & Monochrome Färbung
                img.filters = [
                    new fabric.Image.filters.RemoveColor({
                        color: '#FFFFFF',
                        distance: 0.1 // Schwellenwert für Grautöne/Artefakte
                    }),
                    new fabric.Image.filters.BlendColor({
                        color: color,
                        mode: 'tint',
                        alpha: 1
                    })
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

    // Export Funktion
    window.exportProductDesign = function () {
        guideCircle.visible = false;
        canvas.renderAll();
        const data = canvas.toDataURL({
            format: 'png',
            quality: 1
        });
        guideCircle.visible = true;
        canvas.renderAll();
        return data;
    };

    // Modal Steuerung
    window.openConfiguratorModal = function () {
        const modal = document.getElementById('configurator-modal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Scrollen verhindern

            // Wichtig: Fabric.js muss wissen, dass sich die Position geändert hat
            if (canvas) {
                canvas.calcOffset();
            }
        }
    };

    window.closeConfiguratorModal = function () {
        const modal = document.getElementById('configurator-modal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Scrollen wieder erlauben
        }
    };

    // Schließen bei Klick auf Overlay
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('configurator-modal');
        if (e.target === modal) {
            closeConfiguratorModal();
        }
    });

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
