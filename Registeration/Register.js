document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        let isValid = true; // متغير لتحديد صحة النموذج

        // جلب القيم من الحقول
        const username = form.Username.value.trim();
        const email = form.Email.value.trim();
        const password = form.Password.value.trim();
        const firstName = form.First_name.value.trim();
        const lastName = form.Last_name.value.trim();
        const phone = form.phone.value.trim();
        const gender = form.Gender.value;
        const profileImage = form.profile_image.files[0]; // جلب الملف المحدد

        // التحقق من اسم المستخدم (لا يجب أن يكون فارغًا)
        if (username === "") {
            alert("Username cannot be empty.");
            isValid = false;
        }

        // التحقق من البريد الإلكتروني بصيغة صحيحة
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            isValid = false;
        }

        // التحقق من كلمة المرور (يجب أن تكون 6 أحرف على الأقل)
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            isValid = false;
        }

        // التحقق من الاسم الأول (لا يجب أن يكون فارغًا)
        if (firstName === "") {
            alert("First name cannot be empty.");
            isValid = false;
        }

        // التحقق من الاسم الأخير (لا يجب أن يكون فارغًا)
        if (lastName === "") {
            alert("Last name cannot be empty.");
            isValid = false;
        }

        // التحقق من رقم الهاتف (يجب أن يحتوي فقط على أرقام من 10 إلى 25 رقمًا)
        const phonePattern = /^[0-9]{10,25}$/;
        if (!phonePattern.test(phone)) {
            alert("Phone number must be between 10 and 25 digits.");
            isValid = false;
        }

        // التحقق من تحديد الجنس
        if (gender === "") {
            alert("Please select a gender.");
            isValid = false;
        }

        // التحقق من نوع وحجم الصورة الشخصية
        if (profileImage) {
            const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            if (!allowedTypes.includes(profileImage.type)) {
                alert("Only JPG, JPEG, and PNG files are allowed for the profile image.");
                isValid = false;
            }

            if (profileImage.size > 10 * 1024 * 1024) { // 10MB
                alert("Profile image size must be less than 10MB.");
                isValid = false;
            }
        } else {
            alert("Please upload a profile image.");
            isValid = false;
        }

        // منع إرسال النموذج إذا لم يكن التحقق ناجحًا
        if (!isValid) {
            event.preventDefault();
        }
    });
});
