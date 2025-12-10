# چک‌لیست‌های UI/UX - پنل مشتری

## ماژول ۱: پشتیبانی و تیکت‌ها (Support & Tickets)

### ✅ ساختار Layout
- [x] Header با عنوان و دکمه ایجاد تیکت
- [x] بخش فیلترها (وضعیت، دسته‌بندی، بازه زمانی، جستجو)
- [x] جدول تیکت‌ها با ستون‌های مشخص شده
- [x] Pagination در پایین جدول
- [x] Empty state برای زمانی که تیکتی وجود ندارد

### ✅ Typography و Spacing
- [x] عنوان صفحه: `text-3xl font-bold`
- [x] زیرعنوان: `text-sm text-gray-500`
- [x] فاصله بین بخش‌ها: `mb-6`, `mb-8`
- [x] Padding داخلی کارت‌ها: `p-6`
- [x] فاصله بین ردیف‌های جدول: `divide-y divide-gray-200`

### ✅ Color States
- [x] وضعیت "باز": `bg-green-100 text-green-800`
- [x] وضعیت "در حال بررسی": `bg-yellow-100 text-yellow-800`
- [x] وضعیت "پاسخ داده شده": `bg-blue-100 text-blue-800`
- [x] وضعیت "بسته شده": `bg-gray-100 text-gray-800`
- [x] Badge پیام‌های خوانده نشده: `bg-red-100 text-red-800`
- [x] Hover state برای ردیف‌ها: `hover:bg-gray-50`

### ✅ Icons
- [x] آیکون ایجاد تیکت: Plus icon
- [x] آیکون جستجو: Search icon
- [x] آیکون Empty state: Document icon

### ✅ Empty States
- [x] پیام: "تیکتی وجود ندارد"
- [x] راهنمایی: "برای ایجاد تیکت جدید، روی دکمه..."
- [x] آیکون بزرگ و مرکزی

### ✅ Loading States
- [ ] Skeleton loader برای جدول (برای آینده)
- [ ] Loading spinner برای فیلترها (برای آینده)

### ✅ Error States
- [ ] پیام خطا برای خطاهای شبکه
- [ ] Validation errors در فرم ایجاد تیکت

### ✅ Responsive Behavior
- [x] Grid responsive: `grid-cols-1 md:grid-cols-4` برای فیلترها
- [x] جدول با `overflow-x-auto` برای موبایل
- [x] دکمه‌ها در موبایل full-width

### ✅ Accessibility Rules
- [x] Label برای همه input ها
- [x] ARIA labels برای دکمه‌ها
- [x] Keyboard navigation برای جدول
- [x] Focus states قابل مشاهده

### ✅ Component Inventory
- [x] TicketListTable component
- [x] TicketFilters component
- [x] CreateTicketForm component
- [x] TicketDetailView component
- [x] MessageThread component
- [x] ReplyBox component

---

## ماژول ۲: بکاپ‌ها و Snapshotها (Backups & Snapshots)

### ✅ ساختار Layout
- [x] دو ستون: Snapshots (چپ) و تنظیمات خودکار (راست)
- [x] جدول Snapshots با تمام ستون‌های مورد نیاز
- [x] کارت تنظیمات پشتیبان‌گیری خودکار
- [x] فرم ایجاد Snapshot
- [x] صفحه تأیید بازگردانی

### ✅ Component Spacing
- [x] فاصله بین بخش‌ها: `gap-6`
- [x] Padding داخلی: `p-6`
- [x] Margin بین ردیف‌ها: `divide-y`

### ✅ Table UX
- [x] Hover effect روی ردیف‌ها
- [x] رنگ‌بندی وضعیت‌ها
- [x] دکمه‌های عملیات (بازگردانی، حذف)
- [x] اطلاعات اضافی در tooltip/description

### ✅ Warn Dialogs
- [x] هشدار در صفحه بازگردانی
- [x] Checkbox تأیید برای بازگردانی
- [x] رنگ قرمز برای دکمه تأیید بازگردانی

### ✅ Disabled States
- [x] دکمه بازگردانی فقط برای Snapshotهای تکمیل شده
- [x] Toggle برای فعال/غیرفعال کردن پشتیبان‌گیری

### ✅ Error Handling
- [ ] پیام خطا برای خطاهای ایجاد Snapshot
- [ ] پیام خطا برای خطاهای بازگردانی

### ✅ Success Toasts
- [ ] پیام موفقیت پس از ایجاد Snapshot
- [ ] پیام موفقیت پس از بازگردانی
- [ ] پیام موفقیت پس از حذف

### ✅ Conflicting Operation Warnings
- [x] هشدار در صفحه بازگردانی درباره از دست رفتن داده‌ها
- [x] هشدار در صفحه ایجاد درباره تأثیر بر عملکرد

### ✅ Scheduling UI Patterns
- [x] Dropdown برای انتخاب برنامه زمانی
- [x] Input time برای انتخاب زمان
- [x] Input number برای retention policy
- [x] نمایش آخرین و بعدی پشتیبان‌گیری

### ✅ Mobile Usability Testing Rules
- [x] جدول scrollable در موبایل
- [x] فرم‌ها responsive
- [x] دکمه‌ها قابل لمس (min 44x44px)
- [x] فونت‌ها خوانا در موبایل

---

## ماژول ۳: اعلان‌ها (Notifications)

### ✅ Notification Dropdown Behavior
- [x] باز شدن با کلیک روی آیکون زنگ
- [x] بسته شدن با کلیک خارج
- [x] Animation fade & slide
- [x] نمایش ۵ اعلان آخر
- [x] لینک "مشاهده همه"

### ✅ Read/Unread Indicators
- [x] Badge شمارش خوانده نشده‌ها
- [x] رنگ‌بندی متفاوت برای خوانده نشده‌ها
- [x] Dot indicator در لیست
- [x] Background متفاوت برای خوانده نشده‌ها

### ✅ Badge Update Logic
- [x] به‌روزرسانی خودکار هر ۳۰ ثانیه
- [x] به‌روزرسانی پس از باز کردن dropdown
- [x] نمایش "9+" برای اعداد بالای ۹

### ✅ Mobile Dropdown Interaction
- [x] Dropdown responsive
- [x] Touch-friendly buttons
- [x] Scroll برای لیست طولانی

### ✅ Infinite Scroll or Pagination
- [x] Pagination در صفحه اصلی
- [ ] Infinite scroll (برای آینده)

### ✅ Empty State Farsi Text
- [x] "اعلانی وجود ندارد"
- [x] آیکون و پیام مناسب

### ✅ Performance Considerations
- [x] Lazy loading برای dropdown
- [x] Caching برای کاهش درخواست‌ها
- [x] Debounce برای به‌روزرسانی‌ها

### ✅ Component Inventory
- [x] NotificationBell component
- [x] NotificationDropdown component
- [x] NotificationList component
- [x] NotificationCard component
- [x] NotificationFilters component

---

## قوانین کلی UI/UX

### ✅ RTL Support
- [x] همه صفحات از `$isRtl` استفاده می‌کنند
- [x] Flex direction برای RTL
- [x] Text alignment برای RTL
- [x] Margin/Padding برای RTL

### ✅ Farsi Content
- [x] همه متن‌ها به فارسی
- [x] تاریخ‌ها به فرمت شمسی
- [x] اعداد با جداکننده هزارگان فارسی

### ✅ Color Palette
- [x] Primary: Blue-600
- [x] Success: Green
- [x] Warning: Yellow
- [x] Error: Red
- [x] Neutral: Gray

### ✅ Typography Scale
- [x] Headings: 3xl, 2xl, xl, lg
- [x] Body: base, sm, xs
- [x] Font weights: bold, semibold, medium, normal

### ✅ Spacing System
- [x] Consistent use of Tailwind spacing scale
- [x] Gap between sections: 6, 8
- [x] Padding: 4, 6
- [x] Margin: 4, 6, 8

### ✅ Interactive Elements
- [x] Hover states برای همه لینک‌ها و دکمه‌ها
- [x] Focus states قابل مشاهده
- [x] Transition animations
- [x] Loading states

### ✅ Form Design
- [x] Label برای همه فیلدها
- [x] Placeholder text مفید
- [x] Validation messages
- [x] Required field indicators

### ✅ Responsive Design
- [x] Mobile-first approach
- [x] Breakpoints: sm, md, lg, xl
- [x] Grid systems responsive
- [x] Tables scrollable در موبایل

### ✅ Accessibility
- [x] ARIA labels
- [x] Keyboard navigation
- [x] Focus management
- [x] Color contrast (WCAG AA)

---

## وضعیت پیاده‌سازی

### ✅ تکمیل شده
- [x] ماژول پشتیبانی و تیکت‌ها
- [x] ماژول بکاپ‌ها و Snapshotها
- [x] ماژول اعلان‌ها
- [x] تمام صفحات و فرم‌ها
- [x] Navbar integration
- [x] Routes و Controllers

### 🔄 برای آینده
- [ ] Real-time updates با WebSockets
- [ ] Advanced filtering و search
- [ ] Export functionality
- [ ] Print views
- [ ] Dark mode support
- [ ] Advanced animations
- [ ] Skeleton loaders
- [ ] Error boundaries

---

**تاریخ ایجاد**: ۱۴۰۳/۱۰/۲۲
**آخرین به‌روزرسانی**: ۱۴۰۳/۱۰/۲۲

