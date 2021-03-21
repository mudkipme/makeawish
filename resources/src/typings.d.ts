declare module '*.vue' {
    import type { DefineComponent } from 'vue';
    const component: DefineComponent<{}, {}, any>;
    export default component;
}

declare namespace Inertia {
    interface User {
        id: number;
        email: string;
        name: string;
    }

    type LangValue = string | { [key: string]: LangValue };
    interface PageProps {
        language: Record<string, LangValue>;
        locale: string;
        availableLocales: Record<string, string>;
        errors?: Record<string, string>;
        title?: string;
        user?: User;
    }
}
