window.notificationsList = function() {
    return {
        notifications: [],
        loading: true,

        initNotifications() {
            this.fetchNotifications();
            // Update notifications every minute
            setInterval(() => this.fetchNotifications(), 60000);
        },

        async fetchNotifications() {
            try {
                const response = await fetch('/api/schedules/check-notifications');
                const data = await response.json();
                this.notifications = data;
                this.loading = false;
            } catch (error) {
                console.error('Error fetching notifications:', error);
                this.loading = false;
            }
        },

        getNotificationMessage(notification) {
            const now = new Date();
            const dueDate = new Date(notification.due_schedule);
            const startDate = new Date(notification.start_schedule);
            const beforeDueDate = new Date(notification.before_due_schedule);

            if (now > dueDate && notification.status !== 'completed') {
                return 'This schedule is overdue!';
            } else if (this.isWithinMinutes(now, startDate, 5)) {
                return 'Starting in a few minutes!';
            } else if (this.isWithinMinutes(now, beforeDueDate, 5)) {
                return 'Deadline approaching soon!';
            } else if (this.isWithinMinutes(now, dueDate, 5)) {
                return 'Deadline has arrived!';
            }

            return 'Schedule update';
        },

        isWithinMinutes(date1, date2, minutes) {
            const diff = Math.abs(date1 - date2);
            return diff <= minutes * 60 * 1000;
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
} 