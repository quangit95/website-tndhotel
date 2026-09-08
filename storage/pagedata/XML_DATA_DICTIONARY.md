# Bảng Tra Cứu & Giải Thích Ký Hiệu Dữ Liệu XML (XML Data Dictionary)
### Website: Khách Sạn TND Nha Trang

Tài liệu này giải thích toàn bộ ý nghĩa các thẻ viết tắt và con số quy ước được sử dụng trong các file cơ sở dữ liệu XML tại thư mục `storage/pagedata/`.

---

## 1. Bảng Ý Nghĩa Các Thẻ Viết Tắt (XML Tags)

| Thẻ XML | Tên tiếng Anh đầy đủ | Ý nghĩa Tiếng Việt | Mô tả chi tiết |
|---|---|---|---|
| `<db>` | **Database** | Bản ghi dữ liệu | Chứa thông tin cơ bản của một sản phẩm, phòng hoặc menu. |
| `<id>` | **Identity ID** | Mã định danh duy nhất | Số thứ tự duy nhất của bản ghi (1, 2, 3,...). |
| `<ti>` | **Title** | Tiêu đề chính | Tên phòng, tên bài viết hoặc tên menu. Có 2 ngôn ngữ con: `<vi>` và `<en>`. |
| `<ti1>` | **Sub-title** | Tiêu đề phụ | Dòng mô tả nhỏ hiển thị ngay dưới tiêu đề chính. |
| `<ct>` | **Content / Summary** | Tóm tắt nhanh | Đoạn văn ngắn giới thiệu đặc điểm nổi bật (ví dụ: diện tích phòng). |
| `<tag>` | **Tags** | Thẻ phân loại | Từ khóa dùng để lọc hoặc gợi ý bài viết liên quan. |
| `<cat>` | **Category ID** | Danh mục trực thuộc | ID của Menu mà phòng này thuộc về (Ví dụ: `<cat>2</cat>` là thuộc danh mục Hạng Phòng). |
| `<pr>` | **Price** | Khung giá tiền | Chứa `<sale>` (giá bán thực tế) và `<off>` (giá gốc trước khi giảm). Nếu để trống sẽ hiện "Liên hệ". |
| `<ra>` | **Rating** | Đánh giá sao | Số sao đánh giá của phòng (1 đến 5 sao). |
| `<so>` | **Sort Order** | Thứ tự hiển thị | Số thứ tự sắp xếp ưu tiên hiển thị trước/sau trên website. |
| `<st>` | **Status** | Trạng thái hiển thị | Quy định phòng/menu có được hiển thị ra ngoài web hay không (xem bảng mã số ở mục 2). |
| `<cr>` | **Created Time** | Thời gian tạo | Dãy số Unix Timestamp (số giây tính từ 1970). |
| `<im>` | **Image** | File ảnh đại diện | Tên file ảnh đại diện (lưu trong thư mục upload ảnh). |
| `<pa>` | **Parent ID** | Cấp menu cha | Nếu là `0` là menu cấp 1; nếu khác `0` là menu con của ID đó. |
| `<ism>` | **Is Menu** | Hiển thị trên thanh menu | `1` là hiển thị lên thanh Menu chính trên Header, `0` là ẩn. |
| `<opp>` | **Option Page** | Loại giao diện trang | Phân loại trang là: Trang đơn, Trang danh sách phòng, hay Trang tin tức. |
| `<more>` | **More Details** | Nội dung chi tiết | Chứa phần soạn thảo văn bản mô tả đầy đủ `<description>`. |

---

## 2. Bảng Mã Ý Nghĩa Các Chữ Số Quy Ước (Numeric Codes)

### A. Mã Trạng Thái (`<st>` - Status)
* **`<st>1</st>`**: **Bản nháp / Tạm ẩn (Draft / Hidden)** – Dữ liệu vẫn được lưu trong hệ thống quản trị nhưng không hiển thị ra ngoài cho khách xem.
* **`<st>2</st>`**: **Đang hoạt động / Hiển thị (Active)** – Hiển thị bình thường trên các trang danh mục và tìm kiếm.
* **`<st>3</st>`**: **Nổi bật (Featured)** – Được gắn nhãn nổi bật, ưu tiên hiển thị ở vị trí trang trọng.
* **`<st>4</st>`**: **Hiển thị Trang chủ (Show on Home)** – Tự động lấy ra trình chiếu trên các khối tại Trang chủ.

### B. Mã Phân Loại Danh Mục (`<cat>` - Category)
* **`<cat>2</cat>`**: Thuộc danh mục **Hạng Phòng (ROOM)**.
* **`<cat>7</cat>`**: Thuộc danh mục **Tin Tức & Sự Kiện (News)**.
* **`<cat>9</cat>`**: Thuộc danh mục **Dịch Vụ & Tiện Ích (Services & Facilities)**.

### C. Mã Loại Trang (`<opp>` - Option Page Type)
* **`<opp>1</opp>`**: **Trang đơn (Single Page)** – Dành cho các trang tĩnh như Giới thiệu, Đặt phòng, Liên hệ.
* **`<opp>2</opp>`**: **Trang Blog / Tin tức (Blog Page)** – Hiển thị danh sách các bài viết tin tức.
* **`<opp>3</opp>`**: **Trang Sản phẩm / Phòng (Product Page)** – Hiển thị lưới danh sách các phòng nghỉ kèm nút đặt phòng và giá tiền.

### D. Mã Thời Gian (`<cr>` - Unix Timestamp)
* Là con số đếm thời gian quốc tế (ví dụ: `1684553872`). 
* Cách quy đổi sang ngày tháng thông thường: `20/05/2023 lúc 10:37:52 SA`.

---

## 3. Ví Dụ Cụ Thể Phân Tích File `product/5.xml` (Penthouse Family)

```xml
<information>
  <db>
    <id>5</id>                           <!-- ID của phòng: số 5 -->
    <ti>
      <vi>Penthouse Family</vi>          <!-- Tên phòng Tiếng Việt -->
      <en>Penthouse Family</en>          <!-- Tên phòng Tiếng Anh -->
    </ti>
    <cat>2</cat>                         <!-- Thuộc Menu ID = 2 (Hạng Phòng) -->
    <pr>
      <sale></sale>                      <!-- Giá trống: Trên web hiển thị "Liên hệ" -->
      <off></off>                        <!-- Không có giảm giá -->
    </pr>
    <so>2</so>                           <!-- Thứ tự hiển thị số 2 (xếp vị trí thứ 2) -->
    <st>2</st>                           <!-- Trạng thái số 2: Đang hiển thị công khai -->
    <cr>1684553872</cr>                  <!-- Ngày tạo: 20/05/2023 -->
    <im>5_TND-Penthouse Family (11).jpg</im> <!-- File ảnh phòng đại diện -->
  </db>
  <more>
    <vi>
      <description>...</description>     <!-- Toàn bộ bài giới thiệu chi tiết phòng -->
    </vi>
  </more>
</information>
```

> **Lưu ý quan trọng cho Lập trình viên & Quản trị viên:**  
> Các tên thẻ viết tắt này (`ti`, `cat`, `so`, `st`, `cr`, `im`) là quy chuẩn cấu trúc biến trong toàn bộ mã nguồn PHP và JavaScript Handlebars. Khi cần chỉnh sửa nội dung phòng hoặc menu, bạn nên chỉnh sửa qua giao diện **Admincp** (http://localhost:8000/admincp) để hệ thống tự động lưu đúng chuẩn mà không cần thao tác thủ công vào file XML.

---

## 4. Thông Tin Địa Chỉ Hành Chính Của Khách Sạn

Địa chỉ hiển thị chính thức của khách sạn TND Hotel:
* **Tiếng Việt**: `07 Lê Lợi, Phường Nha Trang, Tỉnh Khánh Hòa, Việt Nam`
* **Tiếng Anh**: `07 Le Loi, Nha Trang Ward, Khanh Hoa Province, Vietnam`
* **Các file lưu trữ**:
  - [home/config.xml](file:///Users/lananhyahoo/DEV/tnd/storage/pagedata/101131/dataxml/home/config.xml) (`<social><address>`, `<footer><vi>`, `<footer><en>`)
  - [menu/8.xml](file:///Users/lananhyahoo/DEV/tnd/storage/pagedata/101131/dataxml/menu/8.xml) (Trang Liên Hệ)
  - [website/101131.xml](file:///Users/lananhyahoo/DEV/tnd/storage/pagedata/website/101131.xml) (`<db><address>`)


