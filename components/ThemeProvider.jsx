'use client';

import { ThemeProvider as NextThemeProvide } from "next-themes";

export function ThemeProvider({children, ...props}) {
    return <NextThemeProvide {...props}>
        {children}
    </NextThemeProvide>;
}