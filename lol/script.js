const flag = "12345"; // Replace with your desired flag
const resultDiv = document.getElementById("result");
const feedbackDiv = document.getElementById("feedback");
const canvas = document.querySelector('canvas');
const ctx = canvas.getContext('2d');
canvas.willReadFrequently = true

function checkGuess() {
  const guess = document.getElementById("guess").value;
  if (guess === flag) {
    resultDiv.textContent = "Correct! The flag is: " + flag;
    feedbackDiv.textContent = "Congratulations, you found the flag!";
  } else {
    resultDiv.textContent = "Incorrect. Try again.";
    feedbackDiv.textContent = "That's not the right combination.";
  }
}

function drawSwirl() {
    ctx.fillStyle = 'black';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath();
    ctx.strokeStyle = 'rgba(0, 255, 0, 0.5)' // Neon green color
    ctx.lineWidth = 2;

    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(canvas.width, canvas.height) /2;

    const numPoints = 20;
    const angleIncrement = Math.PI * 2 / numPoints;
    
    for (let i = 0; i < numPoints; i++) {
        const angle = i * angleIncrement;
        const x = centerX + radius * Math.cos(angle);
        const y = centerY + radius * Math.sin(angle);

        if (i == 0) {
            ctx.moveTo(x, y);
        } else {
          ctx.lineTo(x, y);
        }
    }

    ctx.closePath();
    ctx.stroke();
}

function addGlitch(){
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;

    

    for (let i = 0; i < data.length; i += Math.random() * 10) {
        data[i] = Math.random() * 255;
    }

    ctx.putImageData(imageData, 0, 0);
}

function animate() {
    drawSwirl();
    addGlitch();
    requestAnimationFrame(animate);
}

animate();

