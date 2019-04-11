var scene = new THREE.Scene();
scene.fog = new THREE.Fog('#000033', 200, 300);
scene.background = new THREE.Color('#000033');
const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);

var renderer = new THREE.WebGLRenderer();
renderer.setSize(window.innerWidth, window.innerHeight);
$('.hero-tabs').append(renderer.domElement);

function rotateAround(point, center, angle) {
    angle = (angle) * (Math.PI / 180); // Convert to radians
    var rotatedX = Math.cos(angle) * (point.x - center.x) - Math.sin(angle) * (point.y - center.y) + center.x;
    var rotatedY = Math.sin(angle) * (point.x - center.x) + Math.cos(angle) * (point.y - center.y) + center.y;
    return { x: rotatedX, y: rotatedY }
}
function randint(min, max) {
    return Math.floor(Math.random() * max) + min
}
function RGB(r, g, b) {
    function colorcheck(c) {
        if (c > 255) {
            c = 255
        }
        if (c < 0) {
            c = 0
        }
        return c
    }
    r = colorcheck(r)
    g = colorcheck(g)
    b = colorcheck(b)
    return 'rgb(' + r + ',' + g + ',' + b + ')'
}
function rgb2hex(rgb) {
    rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
    return (rgb && rgb.length === 4) ? "0x" +
        ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : '';
}
function rgb2color(r, g, b) {
    return rgb2hex(RGB(r, g, b))
}

var color = {}
color.r = 0
color.g = 0
color.b = 255
color.rs = 0
color.gs = 0
color.bs = 0
color.rt = 0
color.gt = 0
color.bt = 255
function randoffset(off) {
    return randint(-off, off * 2)
}
function createCanvasMaterial(color, size) {
    var matCanvas = document.createElement('canvas');
    matCanvas.width = matCanvas.height = size;
    var matContext = matCanvas.getContext('2d');
    // create exture object from canvas.
    var texture = new THREE.Texture(matCanvas);
    // Draw a circle
    var center = size / 2;
    matContext.beginPath();
    matContext.arc(center, center, size / 2, 0, 2 * Math.PI, false);
    matContext.closePath();
    matContext.fillStyle = color;
    matContext.fill();
    // need to set needsUpdate
    texture.needsUpdate = true;
    // return a texture made from the canvas
    return texture;
}
//Create elements here:

var rotation_matrix = new THREE.Matrix4().makeRotationX(0.01);

var DNAs = []
function newDNA(position, rotation, length) {
    var DNA = []
    DNA.doublehelix = {}
    DNA.ladder = {}
    //DNA.doublehelix.count = 10 * length

    DNA.doublehelix.particles = new THREE.Geometry();
    DNA.ladder.particles = new THREE.Geometry();
    DNA.doublehelix.colors = [];
    DNA.ladder.colors = [];
    var addp = 0
    var height = 0
    var density = 20
    var curve = -7
    // now create the individual particles
    for (var p = 0; p < length * density; p++) {
        // create a particle with random
        height += 1 / density
        var pX = 5,
            pY = height + (randoffset(10) / 10),
            pZ = 0
        point = { x: pX, y: 0 }
        center = { x: 0, y: 0 }
        addp += 180 + (curve / density)
        r = rotateAround(point, center, addp)
        addp %= 360
        pX = r.x
        pZ = r.y
        var particle = new THREE.Vector3(pX, pY, pZ)

        // add it to the geometry
        DNA.doublehelix.particles.vertices.push(particle);
    }

    var addp = 0
    var height = 0
    var ladderspace = 4
    for (var p = 0; p <= length / ladderspace; p++) {
        // create a particle with random
        for (var i = 0; i < density * 2; i++) {
            var pX = randoffset(50) / 10,
                pY = height + (randoffset(4) / 10),
                pZ = 0
            point = { x: pX, y: 0 }
            center = { x: 0, y: 0 }
            addp += 180
            r = rotateAround(point, center, addp)
            addp %= 360
            pX = r.x
            pZ = r.y
            var particle = new THREE.Vector3(pX, pY, pZ)

            // add it to the geometry
            DNA.ladder.particles.vertices.push(particle);
        }
        addp += curve * ladderspace
        addp %= 360
        height += ladderspace

    }
    // material
    DNA.doublehelix.material = new THREE.PointsMaterial({
        size: 1,
        color: '#0000ff',
        transparent: true,
        depthWrite: false,
        opacity: 0.5
    });
    DNA.ladder.material = new THREE.PointsMaterial({
        size: 1,
        color: '#0000ff',
        transparent: true,
        depthWrite: false,
        opacity: 0.5
    });
    // create the particle system
    DNA.doublehelix.system = new THREE.Points(
        DNA.doublehelix.particles,
        DNA.doublehelix.material);
    DNA.ladder.system = new THREE.Points(
        DNA.ladder.particles,
        DNA.ladder.material);
    // add it to the scene
    DNA.doublehelix.system.add(DNA.ladder.system);
    //DNA.doublehelix.system.add(new THREE.Axes())
    scene.add(DNA.doublehelix.system);

    DNA.doublehelix.system.position.x = position[0]
    DNA.doublehelix.system.position.y = position[1]
    DNA.doublehelix.system.position.z = position[2]

    DNA.doublehelix.system.rotation.x = rotation[0]
    DNA.doublehelix.system.rotation.y = rotation[1]
    DNA.doublehelix.system.rotation.z = rotation[2]
    return DNA;
}
for (var i = 0; i < 50; i++) {
    var position = [randoffset(100), randoffset(100), randint(0, 1000)]
    var rotation = [randint(0, 360), randint(0, 360), randint(0, 360)]
    DNAs.push(newDNA(position, rotation, 300))
}


// The number of particles in a particle system is not easily changed.
var particleCount = 500;

// Particles are just individual vertices in a geometry
// Create the geometry that will hold all of the vertices
var particles = new THREE.Geometry();

// Create the vertices and add them to the particles geometry
for (var p = 0; p < particleCount; p++) {

    // This will create all the vertices in a range of -200 to 200 in all directions
    var x = randoffset(100);
    var y = randoffset(100);
    var z = randint(0, 1000);

    // Create the vertex
    var particle = new THREE.Vector3(x, y, z);

    // Add the vertex to the geometry
    particles.vertices.push(particle);
}

// Create the material that will be used to render each vertex of the geometry
var particleMaterial = new THREE.PointsMaterial(
    {
        color: 0xffffff,
        size: 10,
        map: createCanvasMaterial('#ffffff', 256),
        blending: THREE.AdditiveBlending,
        transparent: true,
        depthWrite: false,
        opacity: 0.1,
    });

// Create the particle system
particleSystem = new THREE.Points(particles, particleMaterial);
scene.add(particleSystem);

//end of elements
camera.position.z = -300;
particleSystem.position.z = -300;
camera.position.y = 0
camera.lookAt(new THREE.Vector3(0, 0, 0))
var render = function () {
    requestAnimationFrame(render);
    mainloop()
    renderer.render(scene, camera);
};
var nextDNA = 0
var speed = 0.7;
var time = 0
function mainloop() {
    time += 1;
    camera.position.z += speed
    camera.rotation.z += 0.002;
    camera.position.y = Math.sin(time / 100) * 20
    camera.rotation.y = Math.sin(time / 100) / 10
    camera.position.x = Math.sin(time / 100) * 20
    particleSystem.position.z += speed;
    particleSystem.rotation.z -= 0.001;
    nextDNA -= 1
    if (nextDNA < 0) {
        var position = [randoffset(200), randoffset(200), camera.position.z + 1000]
        var rotation = [randint(0, 360), randint(0, 360), randint(0, 360)]
        DNAs.push(newDNA(position, rotation, 300))
        nextDNA = 10
    }

    if (Math.abs(color.r - color.rt) >= 5) {
        color.r += color.rs
    }
    if (Math.abs(color.g - color.gt) >= 5) {
        color.g += color.gs
    }
    if (Math.abs(color.b - color.bt) >= 5) {
        color.b += color.bs
    }
    if (Math.abs(color.r - color.rt) < 5 &&
        Math.abs(color.g - color.gt) < 5 &&
        Math.abs(color.b - color.bt) < 5) {
        color.rt = randint(0, 255)
        color.gt = randint(0, 255)
        color.bt = randint(0, 255)
        var divisor = 50
        if (color.rt > color.r) {
            color.rs = randint(5, 45) / divisor
        } else {
            color.rs = -randint(5, 45) / divisor
        }
        if (color.gt > color.g) {
            color.gs = randint(5, 45) / divisor
        } else {
            color.gs = -randint(5, 45) / divisor
        }
        if (color.bt > color.b) {
            color.bs = randint(5, 45) / divisor
        } else {
            color.bs = -randint(5, 45) / divisor
        }
    }

    var r = Math.round(color.r)
    var g = Math.round(color.g)
    var b = Math.round(color.b)

    var darker = 5 // 3

    // camera.rotation.z -= 0.01
    // scene.fog = new THREE.Fog(RGB(Math.round(r / darker), Math.round(g / darker), Math.round(b / darker)), 200, 300);
    // scene.background = new THREE.Color(RGB(Math.round(r / darker), Math.round(g / darker), Math.round(b / darker)));

    scene.fog = new THREE.Fog(RGB(Math.round(40 / darker), Math.round(146 / darker), Math.round(215 / darker)), 200, 300);
    scene.background = new THREE.Color(RGB(Math.round(40 / darker), Math.round(146 / darker), Math.round(215 / darker)));

    for (var i = 0; i < DNAs.length; i++) {
        DNA = DNAs[i]
        //var translation = new THREE.Matrix4().makeTranslation(DNA.doublehelix.system.position.x,
        //                                                      DNA.doublehelix.system.position.y,
        //                                                      DNA.doublehelix.system.position.z);
        //var transformation = rotation_matrix.multiply(translation);
        //DNA.doublehelix.system.applyMatrix(transformation);
        DNA.doublehelix.system.translateY(0.1);
        DNA.doublehelix.system.material.color.setHex(rgb2color(r, g, b));
        DNA.ladder.system.material.color.setHex(rgb2color(r, g, b));
        if (DNA.doublehelix.system.position.z < camera.position.z - 500) {
            scene.remove(DNA.doublehelix.system)
            DNAs.splice(i, 1)
        }
        //var verts = DNA.doublehelix.system.geometry.vertices;
        //for (var l = 0; l < verts.length; l++) {
        //  var vert = verts[i];
        //}
    }
    //camera.position.y += 0.5;

    var verts = particleSystem.geometry.vertices;
    particleSystem.material.color.setHex(rgb2color(r, g, b));
    for (var i = 0; i < verts.length; i++) {
        var vert = verts[i];
        if (vert.z < 0) {
            vert.z = 1000;
        }
        vert.z -= speed * 0.7
    }
    particleSystem.geometry.verticesNeedUpdate = true;
}
render();

window.addEventListener('resize', onWindowResize, false);

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}