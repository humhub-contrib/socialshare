# User Manual

## URL Pattern Placeholders
Use these placeholders in your URL patterns:

- `{url}`: The content permalink (URL encoded)
- `{text}`: The content description/text (URL encoded)
- Example: https://example.com/share?url={url}&text={text}

## Common Provider Examples

### Reddit
- URL Pattern: https://reddit.com/submit?url={url}&title={text}
- Icon Class: reddit
- Icon Color: #ff4500

### Pinterest
- URL Pattern: https://pinterest.com/pin/create/button/?url={url}&description={text}
- Icon Class: pinterest
- Icon Color: #bd081c

### WhatsApp
- URL Pattern: https://wa.me/?text={text}%20{url}
- Icon Class: whatsapp
- Icon Color: #25d366

### Telegram
- URL Pattern: https://t.me/share/url?url={url}&text={text}
- Icon Class: telegram
- Icon Color: #0088cc
