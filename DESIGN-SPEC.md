# World One Trading - デザイン仕様書

リファレンス: LUXE テンプレート（ダークモードHP + ライトモードコレクション）

---

## 1. カラーシステム

### プライマリカラー
| 用途 | カラーコード | 説明 |
|------|-------------|------|
| Primary Gold | `#D4AF37` | メインアクセント、ボタン、リンクホバー、バッジ |
| Gold Vibrant | `#FFD700` | ボタンホバー時 |
| Gold Muted | `#C5A028` | ライトモードでの控えめなゴールド |
| Gold Dark | `#AA8E2F` | ライトモードのホバー用 |

### ゴールドグラデーション（テキスト用）
```css
background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
```

### ダークモード
| 用途 | カラーコード | 説明 |
|------|-------------|------|
| Background | `#09090b` | ページ背景 |
| Charcoal | `#121214` | ヘッダー/フッター背景 |
| Card BG | `#18181b` | カード背景 |
| Surface | `#0c0c0e` | セクション背景（微差） |
| Border | `zinc-800/50` | ボーダー（半透明） |
| Text Primary | `zinc-100` | メインテキスト |
| Text Secondary | `zinc-400` | サブテキスト |
| Text Muted | `zinc-500` | 補助テキスト |
| Text Faint | `zinc-600` | 最小限のテキスト |

### ライトモード
| 用途 | カラーコード | 説明 |
|------|-------------|------|
| Background | `#fdfdfd` | ページ背景 |
| Card BG | `#ffffff` | カード背景 |
| Surface | `gray-50` | セクション背景 |
| Border | `gray-100` | ボーダー |
| Text Primary | `gray-900` | メインテキスト |
| Text Secondary | `gray-500` | サブテキスト |
| Text Muted | `gray-400` | 補助テキスト |
| Text Faint | `gray-300` | 最小限のテキスト |

---

## 2. タイポグラフィ

### フォントファミリー
| 用途 | フォント | ウェイト |
|------|---------|---------|
| 本文・UI | Inter | 100-900 |
| 見出し（セリフ） | Cormorant Garamond | 300-700, italic |

### テキストスタイル一覧

| 要素 | サイズ | ウェイト | スタイル | 追加設定 |
|------|--------|---------|---------|----------|
| ヒーローH1 | `text-6xl` → `text-8xl` (md) | light (300) | serif italic | tracking-tight |
| セクションH2 | `text-5xl` → `text-6xl` | light (300) / extralight (200) | serif italic | tracking-tight |
| サブセクションH2 | `text-3xl` | light (300) | serif | tracking-tight |
| コレクションタイトル | `text-6xl` | extralight (200) | sans-serif | tracking-tight |
| 商品名 | `text-lg` / `text-xs` | medium (500) / light (300) | - | tracking-widest |
| 価格 | `text-lg` / `text-xs` | semibold (600) | - | tracking-widest |
| ナビリンク | `text-[10px]` | bold (700) / medium (500) | uppercase | tracking-[0.2em] |
| ブランドラベル | `text-[10px]` | bold (700) | uppercase | tracking-[0.2em]-[0.3em] |
| セクションラベル | `text-[10px]` | bold (700) | uppercase | tracking-[0.4em]-[0.5em] |
| タグライン | `text-[10px]` | semibold (600) | uppercase | tracking-[0.25em] |
| フッターリンク | `text-xs` / `text-[10px]` | medium (500) | uppercase | tracking-widest |
| 著作権表示 | `text-[10px]` / `text-[9px]` | bold (700) | uppercase | tracking-[0.1em]-[0.5em] |

### テキストカラー使い分け
- **ゴールド (`text-primary`)**: ブランドラベル、セクションラベル、ホバー時、価格（ダークモード）
- **ホワイト**: ヒーローテキスト、商品名（ダークモード）
- **グレー系**: 説明文、サブテキスト

---

## 3. スペーシング・レイアウト

### ページパディング
```
モバイル:  px-6
タブレット: px-10 (md) / px-16 (md)
デスクトップ: px-20 (lg) / px-40 (lg)
```

### 最大幅
- コレクションページ: `max-w-[1440px] mx-auto`
- ホームページ: パディングベース（max-width なし）

### セクション間隔
| セクション | 上下パディング |
|-----------|--------------|
| ヒーロー | `py-10` |
| Houses | `mb-24` |
| Curated | `py-24` |
| Editorial | `py-32` |
| フッター | `py-24` |
| コレクション | `py-12` |

### グリッド
| コンテキスト | カラム数 | ギャップ |
|-------------|---------|---------|
| 商品（HP） | 1 → 2(md) → 3(lg) | `gap-10` |
| 商品（コレクション） | 1 → 2(sm) → 3(xl) | `gap-y-16 gap-x-10` |
| Houses | 横スクロール | `gap-8` |
| フッター | 1 → 2(md) → 4(lg) | `gap-16` |

---

## 4. コンポーネント仕様

### 4.1 ヘッダー

```
位置: sticky top-0 z-50
背景: bg-white/80 (light) / bg-charcoal/90 (dark)
効果: backdrop-blur-xl / backdrop-blur-md
ボーダー: border-b border-gray-200 (light) / border-zinc-800/50 (dark)
パディング: py-4〜5
```

**ロゴ**
- テキスト: uppercase, tracking-[0.2em]
- サイズ: text-2xl
- ウェイト: font-black (HP) / font-light (コレクション)
- フォント: font-serif (HP) / sans-serif (コレクション)
- カラー: text-primary (dark) / text-gray-900 (light)
- SVGアイコン: 28px (size-7), `text-primary`

**ナビゲーション**
- 表示: hidden → xl:flex (HP) / lg:flex (コレクション)
- スタイル: text-[10px] font-bold uppercase tracking-[0.2em]
- カラー: text-zinc-400 (dark) / text-gray-500 (light)
- ホバー: text-primary

**検索**
- HP: 丸型入力 (`rounded-full`, bg-zinc-900)
- コレクション: アンダーライン型 (`border-b`)
- プレースホルダー: uppercase, text-xs

**アイコンボタン**
- サイズ: h-10 w-10 (HP) / p-2 (コレクション)
- 形状: rounded-full
- ホバー: text-primary
- カートバッジ: bg-primary, text-[9px] font-bold text-black

**テーマ切替**
- アイコン: `dark_mode` (HP) / `contrast` (コレクション)
- スタイル: bg-primary/10 text-primary border border-primary/20 (HP)

---

### 4.2 ヒーローセクション（HP）

```
最小高さ: min-h-[700px]
背景: 画像 + グラデーションオーバーレイ
オーバーレイ: linear-gradient(rgba(0,0,0,0.4) 0%, rgba(9,9,11,0.9) 100%)
角丸: rounded-sm (= 0.125rem)
レイアウト: flex items-center justify-center text-center
```

**キャッチコピー構成**
1. サブラベル: text-primary text-sm font-semibold tracking-[0.5em] uppercase
2. メインタイトル: text-8xl font-light font-serif italic (一部 gold-gradient-text)
3. 説明文: text-accent-silver text-lg font-light opacity-80
4. ボタン群: flex-wrap gap-6 mt-6

---

### 4.3 ボタン

**プライマリ（CTA）**
```
高さ: h-14
幅: min-w-[200px]
パディング: px-10
背景: bg-primary
ホバー: bg-gold-vibrant
テキスト: text-black text-[11px] font-bold uppercase tracking-[0.25em]
角丸: なし（デフォルト 0.125rem）
```

**セカンダリ（アウトライン）**
```
高さ: h-14
幅: min-w-[200px]
パディング: px-10
背景: transparent
ボーダー: border border-primary/50
ホバー: bg-white/5, border-primary
テキスト: text-white text-[11px] font-bold uppercase tracking-[0.25em]
```

**Add to Bag / Quick Add（商品カード内）**
```
幅: w-full
パディング: py-4
背景: bg-primary
テキスト: text-black text-[10px] font-bold uppercase tracking-[0.2em]
ホバー: bg-gold-vibrant
```

**ナビゲーション矢印（丸型）**
```
サイズ: h-14 w-14
形状: rounded-full
ボーダー: border border-zinc-800 (通常) / border-primary/50 (アクティブ)
ホバー: bg-zinc-900 / bg-primary/10
```

---

### 4.4 商品カード

#### ホームページ版（ダークモード）
```
レイアウト: flex-col gap-6
画像比率: aspect-[3/4]
画像角丸: rounded-sm
画像背景: bg-charcoal
ホバーアニメ: scale-105, duration-1000
```

**お気に入りボタン（ホバー時表示）**
```
位置: absolute top-6 right-6
サイズ: h-10 w-10
形状: rounded-full
背景: bg-black/40 backdrop-blur-md
表示: opacity-0 → group-hover:opacity-100
```

**Add to Bagオーバーレイ（ホバー時表示）**
```
位置: absolute bottom-0
背景: bg-gradient-to-t from-black/90 to-transparent
アニメ: translate-y-full → group-hover:translate-y-0, duration-500
パディング: p-8
```

**テキスト情報**
```
レイアウト: flex justify-between items-start
ブランドラベル: text-[10px] text-primary uppercase tracking-[0.2em] font-bold mb-2
商品名: text-white font-medium text-lg
価格: text-primary font-semibold text-lg
```

#### コレクション版（ライトモード）
```
レイアウト: group cursor-pointer
画像比率: aspect-[4/5]
画像マージン: mb-6
画像背景: bg-gray-50 (light) / bg-white/5 (dark)
ホバーアニメ: scale-105, duration-1000
```

**Quick Addバー（ホバー時表示）**
```
位置: absolute bottom-0
背景: bg-white/95 (light) / bg-black/95 (dark) backdrop-blur-sm
ボーダー: border-t-2 border-primary
アニメ: opacity-0 translate-y-4 → opacity-1 translate-y-0, duration-300
テキスト: text-[10px] font-bold uppercase tracking-[0.2em]
アイコン: shopping_cart (text-primary)
```

**バッジ**
```
位置: absolute top-4 left-4
背景: bg-primary
テキスト: text-white text-[9px] font-bold uppercase tracking-[0.2em]
パディング: px-3 py-1.5
```

**テキスト情報（中央揃え）**
```
レイアウト: text-center space-y-2
ブランドラベル: text-[10px] uppercase tracking-[0.3em] font-medium text-gray-400
商品名: text-xs font-light tracking-widest truncate
価格: text-xs font-semibold tracking-widest
ホバー: ブランドラベル → text-primary
```

---

### 4.5 Houses セクション（横スクロール）

```
レイアウト: flex overflow-x-auto gap-8
スクロールバー: hidden
カード幅: min-w-[320px]
画像比率: aspect-[4/5]
角丸: rounded-sm
```

**オーバーレイ**
```
通常: bg-black/30
ホバー: bg-black/10, duration-500
```

**テキスト**
```
ブランド名: text-white text-2xl font-light font-serif italic tracking-wide uppercase
位置: absolute bottom-8 left-8
タグライン: text-zinc-500 text-[10px] font-semibold uppercase tracking-[0.25em]
```

**ホバーアイコン**
```
アイコン: north_east (Material Symbols)
カラー: text-primary
表示: opacity-0 → group-hover:opacity-100
```

---

### 4.6 Editorial セクション

```
レイアウト: grid grid-cols-1 lg:grid-cols-2 gap-24 items-center
背景: bg-white (light) / bg-background-dark (dark)
パディング: py-32
```

**画像エリア**
- メイン画像: aspect-[4/5], shadow-[0_0_50px_rgba(212,175,55,0.1)]
- サブ画像: absolute -bottom-10 -right-10, w-1/2, shadow-2xl
- 表示: hidden md:block（サブ画像）

**特徴リスト**
```
アイコンボックス: h-12 w-12, border border-primary/20
ホバー: bg-primary/5
アイコン: text-primary, 24px
タイトル: font-bold tracking-wide
説明: text-sm text-zinc-500 font-light
```

**もっと読むリンク**
```
テキスト: text-[11px] font-bold uppercase tracking-[0.3em] text-primary
アイコン: arrow_right_alt
ホバー: translate-x-3, text-gold-vibrant
```

---

### 4.7 サイドバーフィルター（コレクション）

```
幅: w-64 (lg以上)
スペース: space-y-10
```

**セクションヘッダー**
```
テキスト: text-[11px] uppercase tracking-[0.3em] font-bold
マージン: mb-10
```

**フィルターグループ**
```
ラベル: text-[10px] font-bold uppercase tracking-[0.2em]
アイコン: remove (開) / add (閉)
区切り: border-t border-gray-100, pt-8
```

**チェックボックス**
```
サイズ: w-4 h-4
形状: rounded-none (角なし)
ボーダー: border-gray-300 (light) / border-white/20 (dark)
チェック時カラー: text-primary
ラベル: text-[11px] uppercase tracking-widest text-gray-500
```

**アクティブフィルタータグ**
```
背景: bg-white (light) / bg-white/5 (dark)
ボーダー: border border-primary
テキスト: text-primary text-[10px] font-bold uppercase tracking-widest
閉じるボタン: close アイコン 12px
```

---

### 4.8 ページネーション

```
レイアウト: flex items-center gap-6〜8
位置: mt-32, border-t pt-16
```

**ページ番号**
```
テキスト: text-[11px]
アクティブ: font-bold, border-b-2 border-primary
非アクティブ: font-medium text-gray-400
ホバー: text-gray-900 (light) / text-white (dark)
```

**矢印**
```
アイコン: chevron_left / chevron_right
カラー: text-gray-400
ホバー: text-primary
```

**表示件数**
```
テキスト: text-[9px] font-bold uppercase tracking-[0.4em] text-gray-300
```

---

### 4.9 フッター

```
背景: bg-zinc-50 (light的)/bg-charcoal (dark), bg-white (light)
パディング: py-24
ボーダー: border-t
レイアウト: grid 1→2→4列, gap-16
```

**ニュースレター入力**
- HP版: 独立したinput + button（bg-primary, rounded-sm）
- コレクション版: アンダーライン型（border-b, inline button）

**著作権エリア**
```
マージン: mt-24 pt-10〜12
ボーダー: border-t
レイアウト: flex justify-between
テキスト: text-[9px]-[10px] uppercase tracking-[0.1em]-[0.5em]
```

---

## 5. アニメーション・トランジション

| 要素 | 効果 | Duration |
|------|------|----------|
| 画像ホバー | scale-105 | 1000ms |
| オーバーレイ変化 | bg-black/30 → bg-black/10 | 500ms |
| Add to Bag スライド | translate-y-full → translate-y-0 | 500ms |
| Quick Add 表示 | opacity-0 translate-y-4 → visible | 300ms |
| お気に入りボタン | opacity-0 → opacity-100 | デフォルト |
| テーマ切替 | colors | 500ms |
| リンクホバー | color change | デフォルト |
| 矢印リンク | gap-2 → gap-4 / translate-x-3 | デフォルト |
| スクロールバー | 4px幅, bg-primary (thumb) | - |

---

## 6. アイコン

**使用ライブラリ**: Google Material Symbols Outlined

```css
font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
```

| アイコン名 | 用途 |
|-----------|------|
| search | 検索 |
| favorite | お気に入り |
| shopping_bag | カート |
| shopping_cart | Quick Add |
| dark_mode | テーマ切替（HP） |
| contrast | テーマ切替（コレクション） |
| chevron_left / right | ナビゲーション矢印 |
| arrow_forward | もっと見る |
| arrow_right_alt | もっと読む |
| north_east | Houses ホバー |
| verified | 認証アイコン |
| workspace_premium | プレミアムアイコン |
| person | ユーザーアイコン |
| expand_more | ドロップダウン |
| remove / add | フィルター開閉 |
| close | タグ削除 |
| public / share_reviews / chat_bubble | SNS |

---

## 7. レスポンシブブレークポイント

| ブレークポイント | Tailwind | 主な変化 |
|----------------|----------|---------|
| Mobile | default | 1列グリッド, ナビ非表示, 検索非表示 |
| Small | sm (640px) | 商品2列 |
| Medium | md (768px) | 検索表示, フッター2列 |
| Large | lg (1024px) | サイドバー表示, フッター4列 |
| XL | xl (1280px) | ナビ表示(HP), 商品3列 |

---

## 8. 角丸（Border Radius）

| 値 | サイズ | 用途 |
|----|--------|------|
| DEFAULT | 0.125rem (2px) | カード、画像、ボタン |
| lg | 0.25rem (4px) | - |
| xl | 0.5rem (8px) | - |
| full | 9999px | 検索入力、丸ボタン |

※ 全体的にシャープなデザイン（ほぼ角丸なし）

---

## 9. ダーク/ライト切替

**方式**: `class` ベース（`<html class="dark">`）
**トグル**: `document.documentElement.classList.toggle('dark')`
**永続化**: localStorage 使用
**トランジション**: `transition-colors duration-500` (body)

---

## 10. スクロールバー

```css
::-webkit-scrollbar {
    width: 4px;
}
::-webkit-scrollbar-track {
    background: #09090b;
}
::-webkit-scrollbar-thumb {
    background: #D4AF37;
}
```

---

## 11. 技術スタック

| 項目 | 使用技術 |
|------|---------|
| CSS Framework | Tailwind CSS (CDN) |
| フォント配信 | Google Fonts |
| アイコン | Google Material Symbols Outlined |
| ダークモード | Tailwind `darkMode: "class"` |
| カスタムカラー | Tailwind config extend |

---

## 12. World One Trading 向けカスタマイズ項目

以下をリファレンスから変更する必要がある:

| 項目 | LUXE（現在） | World One Trading（変更後） |
|------|-------------|---------------------------|
| ブランド名 | LUXE | WORLD ONE TRADING |
| ロゴ | SVGシンボル | テキストロゴ or カスタムSVG |
| ナビ項目 | New Arrivals, Collections, Women, Men, Maison | Shop, Brands, About, Shipping |
| Houses | 架空ブランド | HERMES, GUCCI, DIOR, LOUIS VUITTON 等 |
| 商品画像 | Google AIDA CDN | メルカリ商品画像（自前ホスト） |
| 商品名 | ダミー | 実際のメルカリ出品データ |
| 価格 | USD | JPY → USD 変換済み |
| フッター | Department, Maison | Shop, About, Shipping, Returns |
| ニュースレター | あり | あり（or SNSリンクに変更） |
| バッジ | Premium Selection, Limited Edition | Condition: S, A, B, C |
| フィルター | Category, Designer, Price | Brand, Condition, Price, Category |
| コピーライト | LUXE GLOBAL ARBITER | WORLD ONE TRADING |
