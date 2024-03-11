</div>
</div>

<script src="assets/js/highlight.min.js"></script>
<script src="assets/js/alpine-collaspe.min.js"></script>
<script src="assets/js/alpine-persist.min.js"></script>
<script src="assets/js/flatpickr.js"></script>
<script defer src="assets/js/alpine-ui.min.js"></script>
<script defer src="assets/js/alpine-focus.min.js"></script>
<script defer src="assets/js/alpine.min.js"></script>
<script src="assets/js/custom.js"></script>
<script defer src="assets/js/apexcharts.js"></script>

<script> 
    document.addEventListener('alpine:init', () => {
        Alpine.data('scrollToTop', () => ({
            showTopButton: false,
            init() {
                window.onscroll = () => {
                    this.scrollFunction();
                };
            },

            scrollFunction() {
                if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                    this.showTopButton = true;
                } else {
                    this.showTopButton = false;
                }
            },

            goToTop() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            },
        }));

        // sidebar section
        Alpine.data('sidebar', () => ({
            init() {
                const selector = document.querySelector('.sidebar ul a[href="' + window.location.pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.click();
                            });
                        }
                    }
                }
            },
        }));

        // header section
        Alpine.data('header', () => ({
            notifications: [],
            init() {
                const selector = document.querySelector('ul.horizontal-menu a[href="' + window.location
                    .pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.classList.add('active');
                            });
                        }
                    }
                }
                this.getNotifications();
                setInterval(() => {
                    console.log("working");
                    this.getNotifications();
                }, 6000);
            },
            getNotifications() {
                fetch('./ajax/notifications.php?action=get_notification')
                    .then(response => response.json())
                    .then(data => {
                        this.notifications = data;
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
            },
            playNotificationSound(){
                fetch('./ajax/notifications.php?action=play_noti_sound')
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error Playing sound:', error);
                })
            },

            removeNotification(id) {
                this.notifications = this.notifications.filter(notification => notification.id !== id);
            },
        }));

    });
</script>
</body>

</html>