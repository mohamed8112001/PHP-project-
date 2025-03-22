document.addEventListener('DOMContentLoaded', function() {
    gsap.registerPlugin(ScrollTrigger);
   
    
    const productItems = document.querySelectorAll('.product-grid-item');
    productItems.forEach((item, index) => {
        gsap.from(item, {
            duration: 0.6,
            opacity: 0,
            y: 50,
            scale: 0.9,
            rotation: Math.random() * 5 * (Math.random() > 0.5 ? 1 : -1),
            delay: index * 0.1,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: item,
                start: "top bottom-=100",
                toggleActions: "play none none none"
            }
        });
        
        item.addEventListener('mouseenter', () => {
            gsap.to(item, {
                y: -10,
                scale: 1.05,
                boxShadow: "0 15px 30px rgba(0,0,0,0.15)",
                duration: 0.3,
                ease: "power2.out"
            });
            
            gsap.to(item.querySelector(':after'), {
                opacity: 1,
                duration: 0.5
            });
        });
        
        item.addEventListener('mouseleave', () => {
            gsap.to(item, {
                y: 0,
                scale: 1,
                boxShadow: "0 4px 10px rgba(0,0,0,0.05)",
                duration: 0.3,
                ease: "power2.out"
            });
            
            gsap.to(item.querySelector(':after'), {
                opacity: 0,
                duration: 0.5
            });
        });
        
        item.onclick=(e) => {
            createSparkleEffect(e, item);
            
            gsap.to(item, {
                backgroundColor: "rgba(52, 152, 219, 0.2)",
                duration: 0.3,
                yoyo: true,
                repeat: 1,
                ease: "power1.inOut"
            });
            
            gsap.timeline()
                .to(item.querySelector('img'), {
                    scale: 1.3,
                    duration: 0.2,
                    ease: "power1.out"
                })
                .to(item.querySelector('img'), {
                    scale: 1,
                    duration: 0.4,
                    ease: "elastic.out(1, 0.3)"
                });
            
            addToCartWithAnimation(item);
        };
    });

    gsap.from(".order-card", {
        duration: 0.8,
        opacity: 0,
        x: -50,
        ease: "back.out(1.7)"
    });

    gsap.from(".order-item", {
        duration: 0.5,
        opacity: 0,
        x: -30,
        stagger: 0.2,
        ease: "power1.out",
        delay: 0.5
    });
    
    const buttons = document.querySelectorAll('.btn-circle, .btn-confirm');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            gsap.to(btn, {duration: 0.3, scale: 1.1, ease: "power1.out"});
        });
        
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, {duration: 0.3, scale: 1, ease: "power1.out"});
        });
    });
    
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.onclick= () => {
        gsap.timeline()
            .to(confirmButton, {
                duration: 0.1,
                scale: 0.9,
                ease: "power1.in"
            })
            .to(confirmButton, {
                duration: 0.2,
                scale: 1,
                ease: "back.out(2)"
            })
            .to(confirmButton, {
                duration: 0.3,
                backgroundColor: "#27ae60",
                ease: "power1.inOut"
            });
        
        showSuccessMessage();
    };
    
    setupQuantityControls();
});

function createSparkleEffect(event, element) {
    for (let i = 0; i < 8; i++) {
        const sparkle = document.createElement('div');
        sparkle.className = 'sparkle';
        
        const rect = element.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        
        sparkle.style.left = `${x}px`;
        sparkle.style.top = `${y}px`;
        sparkle.style.width = `${Math.random() * 10 + 5}px`;
        sparkle.style.height = sparkle.style.width;
        
        element.appendChild(sparkle);
        
        const angle = Math.random() * Math.PI * 2;
        const distance = Math.random() * 60 + 20;
        const destX = x + Math.cos(angle) * distance;
        const destY = y + Math.sin(angle) * distance;
        
        gsap.to(sparkle, {
            x: destX - x,
            y: destY - y,
            opacity: 0,
            scale: 2,
            duration: 0.8,
            ease: "power1.out",
            onComplete: () => {
                sparkle.remove();
            }
        });
    }
}

function addToCartWithAnimation(productItem) {
    const productName = productItem.querySelector('h6').textContent;
    const productPrice = productItem.querySelector('.product-price').textContent;

    

    const productImg = productItem.querySelector('img');
    const imgClone = productImg.cloneNode(true);
    
    document.body.appendChild(imgClone);
    imgClone.style.position = 'fixed';
    imgClone.style.zIndex = '1000';
    imgClone.style.width = '50px';
    imgClone.style.height = '50px';
    imgClone.style.borderRadius = '50%';
    imgClone.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
    
    const imgRect = productImg.getBoundingClientRect();
    const cartRect = document.querySelector('.order-card').getBoundingClientRect();
    
    imgClone.style.left = `${imgRect.left}px`;
    imgClone.style.top = `${imgRect.top}px`;
    
    gsap.to(imgClone, {
        duration: 0.8,
        left: cartRect.left + 20,
        top: cartRect.top + 20,
        rotation: 360,
        scale: 0.5,
        ease: "power3.inOut",
        onComplete: () => {
            imgClone.remove();
            
            addItemToCartDOM(productName, productPrice);
            
            gsap.to('.order-card', {
                scale: 1.03,
                duration: 0.2,
                yoyo: true,
                repeat: 1,
                ease: "power1.inOut"
            });
        }
    });
}

function addItemToCartDOM(productName, productPrice) {
    const existingItems = document.querySelectorAll('.order-item');
    let found = false;
    
    existingItems.forEach(item => {
        const itemName = item.querySelector('h6').textContent;
        if (itemName === productName) {
            found = true;

            const quantityInput = item.querySelector('.quantity-input');
            const currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
            
            gsap.timeline()
                .to(item, {
                    backgroundColor: "rgba(46, 204, 113, 0.2)",
                    duration: 0.3
                })
                .to(item, {
                    backgroundColor: "transparent",
                    duration: 0.5
                });
            
            gsap.to(quantityInput, {
                scale: 1.2,
                duration: 0.2,
                yoyo: true,
                repeat: 1,
                ease: "power1.inOut"
            });
            
            updateTotalPrice();
        }
    });
    
    if (!found) {
        const orderItems = document.getElementById('orderItems');
        const newItem = document.createElement('div');
        newItem.className = 'order-item';
        newItem.innerHTML = `
            <div>
                <h6 class="mb-0">${productName}</h6>
                <small class="text-muted">${productPrice}</small>
            </div>
            <div class="quantity-control">
                <button class="btn btn-outline-secondary btn-circle decrease-btn">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="text" class="quantity-input" value="1" readonly>
                <button class="btn btn-outline-primary btn-circle increase-btn">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-outline-danger btn-circle ms-2 remove-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        orderItems.appendChild(newItem);
        
        gsap.from(newItem, {
            x: -30,
            y: 10,
            opacity: 0,
            duration: 0.5,
            ease: "back.out(1.7)"
        });
        
        setupQuantityControls();
        updateTotalPrice();
    }
}

function setupQuantityControls() {
    document.querySelectorAll('.increase-btn').forEach(btn => {
        btn.onclick = function() {
            const input = this.parentElement.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
            updateTotalPrice();
            
            // Animation
            gsap.from(input, {
                scale: 1.2,
                duration: 0.3,
                ease: "power1.out"
            });
        };
    });
    
    document.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.onclick = function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateTotalPrice();
                
                gsap.from(input, {
                    scale: 0.8,
                    duration: 0.3,
                    ease: "power1.out"
                });
            }
        };
    });
    
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.onclick = function() {
            const item = this.closest('.order-item');
            
            gsap.to(item, {
                x: -100,
                opacity: 0,
                duration: 0.3,
                ease: "power1.in",
                onComplete: function() {
                    item.remove();
                    updateTotalPrice();
                }
            });
        };
    });
}

function updateTotalPrice() {
    let total = 0;
    
    document.querySelectorAll('.order-item').forEach(item => {
        const priceText = item.querySelector('small').textContent;
        const price = parseInt(priceText.match(/\d+/)[0]);
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        total += price * quantity;
    });
    
    const totalElement = document.querySelector('.total-price');
    const oldTotal = parseInt(totalElement.textContent.match(/\d+/)[0]);
    
    gsap.to({value: oldTotal}, {
        duration: 0.5,
        value: total,
        ease: "power1.out",
        onUpdate: function() {
            totalElement.textContent = `EGP ${Math.round(this.targets()[0].value)}`;
        }
    });
}

function showSuccessMessage() {
    const messageContainer = document.createElement('div');
    messageContainer.style.position = 'fixed';
    messageContainer.style.top = '0';
    messageContainer.style.left = '0';
    messageContainer.style.width = '100%';
    messageContainer.style.height = '100%';
    messageContainer.style.display = 'flex';
    messageContainer.style.justifyContent = 'center';
    messageContainer.style.alignItems = 'center';
    messageContainer.style.pointerEvents = 'none';
    messageContainer.style.zIndex = '2000';
    document.body.appendChild(messageContainer);


    const message = document.createElement('div');
    message.style.backgroundColor = '#2ecc71';
    message.style.color = 'white';
    message.style.padding = '20px 40px';
    message.style.borderRadius = '30px';
    message.style.boxShadow = '0 10px 30px rgba(46, 204, 113, 0.3)';
    message.style.fontWeight = 'bold';
    message.style.fontSize = '18px';
    message.style.display = 'flex';
    message.style.alignItems = 'center';
    message.style.gap = '15px';
    message.innerHTML = '<i class="fas fa-check-circle fa-2x"></i>Order confirmed successfully!';
    messageContainer.appendChild(message);
    
    for (let i = 0; i < 100; i++) {
        createConfetti(messageContainer);
    }
    gsap.from(message, {
        scale: 0.5,
        opacity: 0,
        duration: 0.6,
        ease: "elastic.out(1, 0.5)"
    });
    gsap.to(message.querySelector('i'), {
        rotate: 360,
        duration: 0.5,
        ease: "power1.out"
    });

    setTimeout(() => {
        gsap.to(message, {
            scale: 1.2,
            opacity: 0,
            duration: 0.5,
            ease: "power2.in",
            onComplete: () => {
                messageContainer.remove();
            }
        });
    }, 3000);
}

function createConfetti(container) {
    const confetti = document.createElement('div');
    
    const size = Math.random() * 10 + 5;
    const colors = ['#3498db', '#2ecc71', '#f39c12', '#e74c3c', '#9b59b6', '#1abc9c'];
    const color = colors[Math.floor(Math.random() * colors.length)];
    
    confetti.style.position = 'absolute';
    confetti.style.width = `${size}px`;
    confetti.style.height = `${size}px`;
    confetti.style.backgroundColor = color;
    confetti.style.borderRadius = '50%';
    confetti.style.opacity = Math.random() * 0.7 + 0.3;
    
    container.appendChild(confetti);
    
    gsap.fromTo(confetti, 
        {
            x: window.innerWidth / 2,
            y: window.innerHeight / 2,
            scale: 0
        },
        {
            x: Math.random() * window.innerWidth,
            y: Math.random() * window.innerHeight,
            scale: 1,
            rotation: Math.random() * 360,
            duration: Math.random() * 2 + 1,
            ease: "power1.out",
            onComplete: () => {
                gsap.to(confetti, {
                    y: '+=100',
                    opacity: 0,
                    duration: 1,
                    ease: "power1.in",
                    onComplete: () => confetti.remove()
                });
            }
        }
    );
}