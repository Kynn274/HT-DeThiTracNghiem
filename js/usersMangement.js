const showEvidenceBtn = document.querySelectorAll('.show-evidence-btn');
const showInfoBtn = document.querySelectorAll('.show-info-btn');
const banBtn = document.querySelectorAll('.ban-btn');
const activateBtn = document.querySelectorAll('.activate-btn');
const resetBtn = document.querySelectorAll('.reset-btn');


showEvidenceBtn.forEach(btn => {
  btn.addEventListener('click', () => {
    const evidence = btn.value;
    document.querySelector('.show-evidence').style.display = 'block';
    document.querySelector('.show-evidence img').src = 'images/' + evidence;
    console.log(evidence);
  });
});

showInfoBtn.forEach(button => {
    button.addEventListener('click', function() {
        const userID = this.value;
        
        fetch('method/process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=getUserInfo&userID=${userID}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fill in the user info modal
                if(data.data.Avatar != '' && data.data.Avatar != null){
                    document.querySelector('.show-info .avatar img').src = 'images/' + data.data.Avatar;
                }else{
                    document.querySelector('.show-info .avatar img').src = 'images/no-avatar.jpg';
                }
                document.getElementById('fullname').value = data.data.Fullname || '';
                document.getElementById('email').value = data.data.Email || '';
                document.getElementById('phone').value = data.data.PhoneNumber || '';
                document.getElementById('birthday').value = data.data.DateOfBirth || '';
                
                // Show the modal
                document.querySelector('.show-info').style.display = 'block';
            } else {
                alert('Could not fetch user information');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while fetching user information');
        });
    });
});

// Add HTML for confirmation modal at the end of your QuanLyNguoiDung.php file
const confirmationHTML = `
<div class="confirmation-panel" style="display: none;">
    <div class="container">
        <h2>Xác nhận hành động</h2>
        <p>Bạn có chắc chắn muốn hạn chế tài khoản này không?</p>
        <div class="button-group">
            <button class="btn btn-secondary cancel-btn">Hủy</button>
            <button class="btn btn-danger confirm-btn">Xác nhận</button>
        </div>
    </div>
</div>
`;
document.body.insertAdjacentHTML('beforeend', confirmationHTML);

// Add CSS for confirmation panel
const style = document.createElement('style');
style.textContent = `
    .confirmation-panel {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
    }
    .confirmation-panel .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        min-width: 300px;
        width: fit-content;
    }
    .confirmation-panel .button-group {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
`;
document.head.appendChild(style);

// Update ban button click handler
banBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        const userID = btn.value;
        const username = btn.closest('tr').querySelector('input[type="text"]').value;
        const confirmationPanel = document.querySelector('.confirmation-panel');
        const confirmBtn = confirmationPanel.querySelector('.confirm-btn');
        const cancelBtn = confirmationPanel.querySelector('.cancel-btn');

        // Update confirmation message with username
        confirmationPanel.querySelector('p').textContent = 
            `Bạn có chắc chắn muốn hạn chế tài khoản "${username}" không?`;

        // Show confirmation panel
        confirmationPanel.style.display = 'block';

        // Handle cancel
        cancelBtn.onclick = () => {
            confirmationPanel.style.display = 'none';
        };

        // Handle confirm
        confirmBtn.onclick = () => {
            fetch('method/process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=banUser&userID=${userID}`
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    alert('Hạn chế tài khoản thành công');
                    // Reload page to reflect changes
                    window.location.reload();
                } else {
                    alert('Không thể hạn chế tài khoản này');
                }
            })
            .catch(textStatus => {
                console.error('Error:', textStatus);
                alert('Đã xảy ra lỗi khi hạn chế tài khoản');
            })
            .finally(() => {
                confirmationPanel.style.display = 'none';
            });
        };
    });
});

activateBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        const userID = btn.value;
        fetch('method/process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=activateUser&userID=${userID}`
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.success){
                alert('Kích hoạt tài khoản thành công');
                // Reload page to reflect changes
                window.location.reload();
            }else{
                alert('Không thể kích hoạt tài khoản này');
            }
        })
        .catch(textStatus => {
            console.error('Error:', textStatus);
            alert('Đã xảy ra lỗi khi kích hoạt tài khoản');
        });
    });
});

// Close confirmation panel when clicking outside
document.querySelector('.confirmation-panel').addEventListener('click', (e) => {
    if (e.target === document.querySelector('.confirmation-panel')) {
        document.querySelector('.confirmation-panel').style.display = 'none';
    }
});

// Close buttons functionality
document.querySelector('.close-info').addEventListener('click', function() {
    document.querySelector('.show-info').style.display = 'none';
});

document.querySelector('.close-evidence').addEventListener('click', function() {
    document.querySelector('.show-evidence').style.display = 'none';
});