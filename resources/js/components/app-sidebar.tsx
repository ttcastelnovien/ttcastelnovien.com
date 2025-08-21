import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import type { NavGroup, NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { LayoutGrid, Undo2 } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavGroup[] = [
	{
		title: 'Tableau de bord',
		items: [
			{
				title: 'Accueil',
				href: '/dashboard',
				icon: LayoutGrid,
			},
		],
	},
];

const footerNavItems: NavItem[] = [
	{
		title: 'Accéder au site web',
		href: 'https://ttcastelnovien.com',
		icon: Undo2,
	},
];

export function AppSidebar() {
	return (
		<Sidebar collapsible="icon" variant="inset">
			<SidebarHeader>
				<SidebarMenu>
					<SidebarMenuItem>
						<SidebarMenuButton size="lg" asChild>
							<Link href="/dashboard" prefetch>
								<AppLogo />
							</Link>
						</SidebarMenuButton>
					</SidebarMenuItem>
				</SidebarMenu>
			</SidebarHeader>

			<SidebarContent>
				<NavMain items={mainNavItems} />
			</SidebarContent>

			<SidebarFooter>
				<NavFooter items={footerNavItems} className="mt-auto" />
				<NavUser />
			</SidebarFooter>
		</Sidebar>
	);
}
