import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import { UserInfo } from '@/components/user-info';
import { useMobileNavigation } from '@/hooks/use-mobile-navigation';
import { type User } from '@/types';
import { Link, router } from '@inertiajs/react';
import { LogOut, Settings, UserStar } from 'lucide-react';

interface UserMenuContentProps {
	user: User;
}

export function UserMenuContent({ user }: UserMenuContentProps) {
	const cleanup = useMobileNavigation();

	const handleLogout = () => {
		cleanup();
		router.flushAll();
	};

	return (
		<>
			<DropdownMenuLabel className="p-0 font-normal">
				<div className="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
					<UserInfo user={user} complete={true} />
				</div>
			</DropdownMenuLabel>
			<DropdownMenuSeparator />
			<DropdownMenuGroup>
				{user.roles.includes('admin') && (
					<DropdownMenuItem asChild>
						<a className="block w-full" href="/admin" onClick={cleanup}>
							<UserStar className="mr-2" />
							Administration
						</a>
					</DropdownMenuItem>
				)}
				<DropdownMenuItem asChild>
					<Link className="block w-full" href={route('profile.edit')} as="button" prefetch onClick={cleanup}>
						<Settings className="mr-2" />
						Réglages du compte
					</Link>
				</DropdownMenuItem>
			</DropdownMenuGroup>
			<DropdownMenuSeparator />
			<DropdownMenuItem asChild>
				<Link className="block w-full" method="post" href={route('logout')} as="button" onClick={handleLogout}>
					<LogOut className="mr-2" />
					Déconnexion
				</Link>
			</DropdownMenuItem>
		</>
	);
}
