# website_theme_wordpress

Process selected Wordpress theme for Tuba website

1. Edit files in /source
2. Run gulp to optimize files
3. Copy /output files back to Wordpress

Wordpress Settings:

1. Create menu and specify order

2. Create pages:
    - 首頁
    - 關於我們
    - 聯絡我們

3. 指定首頁: 外觀 > 自訂 > 指定首頁頁面

4. Install plugin:
    - always edit in html. Set front-page edit-in-html
    - recent posts by category
    - Bop Search Box
    - the Event calendar

5. Set menu:
    - Primary menu:
        - 近期活動 (event calendar)
        - 專案一覽
        - 騎車Q&A
        - 關於我們
        - 如何參與
        - 搜尋
    - Secondary menu:
        - 專案一覽
            - proj 1
            - proj 2
            ...
        - 騎車Q&A
            - article 1
            - article 2
            ...
        - 關於我們
            - ...
        - 如何參與
            - ...
            - ...

6. 編輯 event calendar 中文的方法
    - 編輯 lang/the-events-calendar-zh_TW.po
    - 在OS X上, 用Poedit輸出mo檔, 放回同一個資料夾