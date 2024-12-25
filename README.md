# MDlightWeb
A PHP-based documentation system that renders Markdown files with a clean, responsive interface and dark/light theme support.

## Features

- 📚 Automatic navigation structure from markdown files
- 🎨 Light/Dark theme support
- 📱 Responsive design
- ✨ Clean and modern UI
- 🔗 Smart link handling
- 📝 Advanced Markdown support including:
  - Tables
  - Code blocks with syntax highlighting
  - Footnotes
  - Images with captions
  - Blockquotes
  - Custom link icons
  - Nested lists

## Directory Structure

```
.
├── css/                  # Modular CSS files
│   ├── base.css         # Base styles and resets
│   ├── code.css         # Code block styling
│   ├── content.css      # Main content area styles
│   ├── links.css        # Link styling
│   ├── responsive.css   # Responsive design rules
│   ├── sidebar.css      # Navigation sidebar styles
│   ├── table.css        # Table styling
│   └── theme.css        # Theme variables and switching
├── js/                  # JavaScript modules
│   ├── codeBlock.js     # Code block copy functionality
│   ├── navigation.js    # Navigation handling
│   └── theme.js         # Theme switching logic
├── lib/                 # Third-party libraries
├── md/                  # Markdown content files
└── src/                 # PHP source code
    ├── Content/         # Content rendering
    ├── Markdown/        # Markdown parsing
    └── Navigation/      # Navigation building
```

## Setup

1. Clone the repository
2. Ensure PHP 7.4+ is installed
3. Place your markdown files in the `md/` directory
4. Configure your web server to point to the project directory

## Documentation Structure

Place your markdown files in the `md/` directory. The system will:
- Automatically create navigation from the directory structure
- Use `index.md` or `readme.md` as the landing page
- Generate titles from H1 headers in the files
- Support nested folders for organization

## Theming

The application supports light and dark themes:
- Theme preferences are saved in localStorage
- Automatic switching via the theme toggle button
- CSS variables for easy customization in `theme.css`

## Markdown Features

### Links
- External links open in new tabs
- Custom arrow icon indicates external links
- Hover effects for better UX

### Code Blocks
- Syntax highlighting
- Copy to clipboard functionality
- Language detection

### Tables
- Clean, bordered design
- Responsive on mobile devices
- Alternating row colors

### Images
- Automatic figure/figcaption wrapping
- Responsive sizing
- Optional captions

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## License

MIT License - Feel free to use this project for your documentation needs.
