function onLoadAvatarErr(_this) {
  _this.src = 'images/avatar_default.png';
  _this.onerror = '';
}

const deleteBtns = document.querySelectorAll('.delete-btn')
deleteBtns.forEach((btn) => {
  btn.addEventListener('click', function (event) {
    const check = window.confirm(
      `Ban co chac chan muon xoa khong?`
    )
    if (!check) {
      event.preventDefault()
    }
  })
})

