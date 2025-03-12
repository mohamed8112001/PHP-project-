<?php
include_once('nav.php');
?>

<!-- <div class="container py-4">
        <div class="row">
            <div class="col-md-5">
                <div class="order-card">
                    <h4 class="mb-4">Current Order</h4>
                    
                    <div id="orderItems">
                        <div class="order-item" id="item1">
                            <div>
                                <h6 class="mb-0">Tea</h6>
                                <small class="text-muted">EGP 25</small>
                            </div>
                            <div class="quantity-control">
                                <button class="btn btn-outline-secondary btn-circle decrease-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="text" class="quantity-input" value="5" readonly>
                                <button class="btn btn-outline-primary btn-circle increase-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-circle ms-2 remove-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="order-item" id="item2">
                            <div>
                                <h6 class="mb-0">Cola</h6>
                                <small class="text-muted">EGP 30</small>
                            </div>
                            <div class="quantity-control">
                                <button class="btn btn-outline-secondary btn-circle decrease-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="text" class="quantity-input" value="3" readonly>
                                <button class="btn btn-outline-primary btn-circle increase-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-circle ms-2 remove-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control notes-input" rows="3">1 Tea Extra Sugar</textarea>
                    </div>
                    
                    <div class="mt-4">
                        <label class="form-label">Room</label>
                        <select class="dropdown-select">
                            <option>ComboBox</option>
                            <option>Meeting Room 1</option>
                            <option>Meeting Room 2</option>
                            <option>Office Area</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="total-price">EGP 55</div>
                        <button class="btn btn-confirm" id="confirmButton">
                            <i class="fas fa-check me-2"></i>Confirm
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="mb-4">
                    <h4 class="mb-3">Add to user</h4>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Islam Askar">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                </div>
                
                <div class="product-grid-container" id="productGrid">
                   <div class="product-grid-item">
                        <span class="product-badge product-popular">Popular</span>
                        <img src="https://media.istockphoto.com/id/466073662/photo/tea-cup-on-saucer-with-tea-being-poured.jpg?s=612x612&w=0&k=20&c=skmYl4zd-1Op_YF0pYVh2is4D6fakwK2LPFpRZRMB9U=" alt="Tea" class="product-img">
                        <h6>Tea</h6>
                        <div class="product-price">5 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://images.pexels.com/photos/312418/pexels-photo-312418.jpeg?cs=srgb&dl=pexels-chevanon-312418.jpg&fm=jpg" alt="Coffee" class="product-img">
                        <h6>Coffee</h6>
                        <div class="product-price">8 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://images.unsplash.com/photo-1541241588155-cb5e3d972891?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8bmVzY2FmZXxlbnwwfHwwfHx8MA%3D%3D" alt="Nescafe" class="product-img">
                        <h6>Nescafe</h6>
                        <div class="product-price">12 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <span class="product-badge product-new">New</span>
                        <img src="https://feelgoodfoodie.net/wp-content/uploads/2021/11/how-to-make-hot-chocolate-7.jpg" alt="Hot Chocolate" class="product-img">
                        <h6>Hot Chocolate</h6>
                        <div class="product-price">15 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://www.chinadaily.com.cn/world/images/2015xivisitus/attachement/jpg/site1/20150917/b083fe955aa1176499cf53.jpg" alt="Cola" class="product-img">
                        <h6>Cola</h6>
                        <div class="product-price">10 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://www.thebutterhalf.com/wp-content/uploads/2022/08/Orange-Juice-13.jpg" alt="Orange Juice" class="product-img">
                        <h6>Orange Juice</h6>
                        <div class="product-price">15 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://realfood.tesco.com/media/images/RFO-1400x919-IcedTea-8e156836-69f4-4433-8bae-c42e174212c1-0-1400x919.jpg" alt="Iced Tea" class="product-img">
                        <h6>Iced Tea</h6>
                        <div class="product-price">12 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://www.eatingwell.com/thmb/qtP5zJfjZjS_6lkAGjOoH2XDNEc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/mineral-water-8cc11cec12c7471bac9378fa9757c83f.jpg" alt="Mineral Water" class="product-img">
                        <h6>Mineral Water</h6>
                        <div class="product-price">5 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://lemonsandzest.com/wp-content/uploads/2020/02/Small-Batch-Chocolate-Chip-Cookies-Recipe-3.10.jpg" alt="Cookies" class="product-img">
                        <h6>Cookies</h6>
                        <div class="product-price">8 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <span class="product-badge">Limited</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/2018_01_Croissant_IMG_0685.JPG/640px-2018_01_Croissant_IMG_0685.JPG" alt="Croissant" class="product-img">
                        <h6>Croissant</h6>
                        <div class="product-price">75 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://miakouppa.com/wp-content/uploads/2022/02/Sub-sandwich-edited-4-scaled.jpg" alt="Sandwiches" class="product-img">
                        <h6>Sandwich</h6>
                        <div class="product-price">35 LE</div>
                    </div>
                    
                    <div class="product-grid-item">
                        <img src="https://m.media-amazon.com/images/S/aplus-media/mg/f08bdf4b-7e5f-41c0-9e13-975f0a89a1ec._SL300__.jpg" alt="Chocolate Bar" class="product-img">
                        <h6>Chocolate Bar</h6>
                        <div class="product-price">20 LE</div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="index.js"></script> -->

<?php
include_once('footer.php')
?>