// Tunggu DOM selesai
document.addEventListener('DOMContentLoaded', () => {
    const passwordFields = document.querySelectorAll('input[type="password"]');
  
    passwordFields.forEach((field) => {
      // Buat tombol toggle
      const toggle = document.createElement('button');
      toggle.type = 'button';
      toggle.innerHTML = '👁️'; // Atau bisa pakai ikon lain
      toggle.className = 'absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg focus:outline-none';
  
      // Bungkus inputan dengan div relative
      const wrapper = document.createElement('div');
      wrapper.className = 'relative';
      field.parentNode.insertBefore(wrapper, field);
      wrapper.appendChild(field);
      wrapper.appendChild(toggle);
  
      // Aksi tombol
      toggle.addEventListener('click', () => {
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
        toggle.innerHTML = type === 'password' ? '👁️' : '🙈';
      });
    });
  });
  