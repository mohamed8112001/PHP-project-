<?php
// include_once('templates/navbar.php');
// include_once('templates/footer.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        .background {
            width: 100%;
            height: 100vh;
            background:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('images/rr-abrot-pNIgH0y3upM-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #1c1c1c;
            font-family: 'Poppins', sans-serif;
            color: #ffcc00;
            margin: 0;
        }

        .typing-container {
            display: flex;
            font-size: 4rem;
            font-weight: bold;
            letter-spacing: 3px;
            position: relative;
        }

        .letter {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.4s forwards;
        }

        .cursor {
            display: inline-block;
            width: 5px;
            height: 50px;
            background-color: #ffcc00;
            margin-left: 5px;
            animation: blink 1s infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes blink {
            from, to {
                background-color: transparent;
            }
            50% {
                background-color: #ffcc00;
            }
            
        }
        .top-right-links {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 10px; /* مسافة بين الأزرار */
    }

    .top-right-link {
        font-size: 16px;
        color: #fff;
        text-decoration: none;
        padding: 8px 15px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .top-right-link:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
    </style>
</head>

<body class="background">
    <div class="top-right-links">
        <a href="#" class="top-right-link">Login In</a>
        <a href="#" class="top-right-link">Sign Up</a>
    </div>

    <div class="typing-container" id="text"></div>

    <script>
        const text = "Cafeteria"; 
        const container = document.getElementById("text");
        let index = 0;

        function typeText() {
            if (index < text.length) {
                const span = document.createElement("span");
                span.classList.add("letter");
                span.textContent = text.charAt(index);
                span.style.animationDelay = `${index * 0.08}s`; 
                container.appendChild(span);
                index++;
                setTimeout(typeText, 80); 
            } else {
                const cursor = document.createElement("div");
                cursor.classList.add("cursor");
                container.appendChild(cursor);

                setTimeout(() => {
                    container.style.color = '#ffffff';
                    cursor.style.backgroundColor = '#ffffff';
                }, 500);
            }
        }

        window.onload = () => {
            typeText();
        };
    </script>
</body>

</html>
