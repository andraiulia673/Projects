async function loadImageFromJSON() {
    const timestamp = new Date().getTime();

    const res = await fetch(`https://dog.ceo/api/breeds/image/random?timestamp=${timestamp}`);
    const jsonData = await res.json();

    const imageUrl = jsonData.message;

    const img = new Image();
    img.crossOrigin = 'Anonymous';
    img.src = imageUrl;

    img.onload = async function () {
        const canvas = document.getElementById('imageCanvas');
        const ctx = canvas.getContext('2d');

        canvas.width = img.width * 2; // pentru a avea loc ambele imagini una dupa alta
        canvas.height = img.height;

        ctx.drawImage(img, 0, 0); // deseneaza imaginea originala

        const originalImage = document.getElementById('originalImage');
        originalImage.src = img.src;

        const imageData = ctx.getImageData(0, 0, img.width, img.height);
        const data = imageData.data;

        const mirroredData = new Uint8ClampedArray(data);//copie

        for (let y = 0; y < img.height; y++) {
            for (let x = 0; x < img.width / 2; x++) {
                const index = (y * img.width + x) * 4;
                const mirrorIndex = ((y + 1) * img.width - x - 1) * 4;

                for (let i = 0; i < 4; i++) {
                    const temp = mirroredData[index + i];
                    mirroredData[index + i] = mirroredData[mirrorIndex + i];
                    mirroredData[mirrorIndex + i] = temp;
                }
            }
        }
        const mirroredImageData = new ImageData(mirroredData, img.width, img.height);
        ctx.putImageData(mirroredImageData, img.width, 0);

        const mirroredImage = document.getElementById('mirroredImage');
        mirroredImage.src = canvas.toDataURL();
    };
}

loadImageFromJSON();
