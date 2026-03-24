    
        document.addEventListener('alpine:init', () => {
            Alpine.data('readingTest', () => ({
                currentPassage: 1,
                activeTool: null,
                activeColor: null,
                isDrawingMode: false,
                penSize: 3,
                
                setTool(tool, color = null) {
                    if (this.activeTool === tool && this.activeColor === color) {
                        this.activeTool = null;
                        this.activeColor = null;
                    } else {
                        this.activeTool = tool;
                        this.activeColor = color;
                        this.isDrawingMode = false;
                    }
                    this.updateCursor();
                },

                toggleDrawing() {
                    this.isDrawingMode = !this.isDrawingMode;
                    if (this.isDrawingMode) {
                        this.activeTool = 'draw';
                        this.activeColor = 'blue';
                        this.initCanvas();
                    } else {
                        this.activeTool = null;
                    }
                    this.updateCursor();
                },

                updateCursor() {
                    const textPane = this.$refs.textPane;
                    const canvas = document.getElementById('drawingCanvas');
                    
                    if (this.isDrawingMode) {
                        textPane.style.cursor = 'crosshair';
                        canvas.classList.add('active');
                    } else if (this.activeTool === 'highlight') {
                        textPane.style.cursor = 'text';
                        canvas.classList.remove('active');
                    } else if (this.activeTool === 'remove_highlight') {
                        textPane.style.cursor = 'pointer';
                        canvas.classList.remove('active');
                    } else {
                        textPane.style.cursor = 'auto';
                        canvas.classList.remove('active');
                    }
                },

                startSelection(e) {
                    if (this.activeTool === 'remove_highlight') {
                        if (e.target.tagName === 'SPAN' && e.target.className.includes('highlight-')) {
                            const text = e.target.innerText;
                            const textNode = document.createTextNode(text);
                            e.target.parentNode.replaceChild(textNode, e.target);
                        }
                    }
                },

                handleMouseUp() {
                    if (this.activeTool !== 'highlight') return;
                    
                    const selection = window.getSelection();
                    if (!selection.rangeCount || selection.isCollapsed) return;

                    const range = selection.getRangeAt(0);
                    const container = range.commonAncestorContainer;
                    
                    if (this.$refs.textPane.contains(container.nodeType === 3 ? container.parentNode : container)) {
                        const span = document.createElement('span');
                        span.className = `highlight-${this.activeColor}`;
                        
                        try {
                            range.surroundContents(span);
                        } catch (e) {
                            console.warn("Complex selection spanning multiple elements. Simplifying.");
                            const text = range.toString();
                            const fragment = range.extractContents();
                            span.appendChild(fragment);
                            range.insertNode(span);
                        }
                        selection.removeAllRanges();
                    }
                },

                initCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    const textPane = this.$refs.textPane;
                    const ctx = canvas.getContext('2d');
                    
                    canvas.width = textPane.clientWidth;
                    canvas.height = window.innerHeight; // Fill viewport height to allow drawing across scroll
                    
                    let isDrawing = false;
                    let lastX = 0;
                    let lastY = 0;

                    const getPos = (e) => {
                        const rect = canvas.getBoundingClientRect();
                        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
                    };

                    const draw = (e) => {
                        if (!isDrawing || !this.isDrawingMode) return;
                        
                        const {x, y} = getPos(e);
                        ctx.beginPath();
                        ctx.moveTo(lastX, lastY);
                        ctx.lineTo(x, y);
                        ctx.strokeStyle = 'rgba(59, 130, 246, 0.7)'; // blue-500 semantic
                        ctx.lineWidth = this.penSize;
                        ctx.lineCap = 'round';
                        ctx.lineJoin = 'round';
                        ctx.stroke();
                        [lastX, lastY] = [x, y];
                    };

                    canvas.onmousedown = (e) => {
                        if (!this.isDrawingMode) return;
                        isDrawing = true;
                        const {x, y} = getPos(e);
                        [lastX, lastY] = [x, y];
                    };
                    canvas.onmousemove = draw;
                    canvas.onmouseup = () => isDrawing = false;
                    canvas.onmouseout = () => isDrawing = false;
                },

                resizeCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    if(canvas && canvas.width) {
                        const textPane = this.$refs.textPane;
                        const ctx = canvas.getContext('2d');
                        const tempCanvas = document.createElement('canvas');
                        tempCanvas.width = canvas.width;
                        tempCanvas.height = canvas.height;
                        tempCanvas.getContext('2d').drawImage(canvas, 0, 0);
                        
                        canvas.width = textPane.clientWidth;
                        canvas.height = window.innerHeight;
                        ctx.drawImage(tempCanvas, 0, 0);
                    }
                },

                clearCanvas() {
                    const canvas = document.getElementById('drawingCanvas');
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            }));
        });
    
