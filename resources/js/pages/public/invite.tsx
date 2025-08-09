import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { Invitation } from '@/types';

type AcceptInvitationForm = {
	username: string;
	password: string;
};

interface PageProps {
	invitation: Invitation;
}

export default function AcceptInvitation({ invitation }: PageProps) {
	const { data, setData, post, processing, errors, reset } = useForm<Required<AcceptInvitationForm>>({
		username: '',
		password: '',
	});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();
		post(route('public.invite.accept'), {
			onFinish: () => reset('password'),
		});
	};

	return (
		<AuthLayout title="Invitation à rejoindre le club" description="Reseignez vos informations pour accepter l'invitation">
			<Head title="Invitation à rejoindre TTCastelnovien" />

			<form className="flex flex-col gap-6" onSubmit={submit}>
				<div className="grid gap-6">
					<div className="grid gap-2">
						<Label htmlFor="username">username</Label>
						<Input
							id="username"
							type="text"
							required
							autoFocus
							tabIndex={1}
							value={data.username}
							onChange={(e) => setData('username', e.target.value)}
						/>
						<InputError message={errors.username} />
					</div>

					<div className="grid gap-2">
						<Label htmlFor="password">Password</Label>
						<Input
							id="password"
							type="password"
							required
							tabIndex={2}
							autoComplete="new-password"
							value={data.password}
							onChange={(e) => setData('password', e.target.value)}
						/>
						<InputError message={errors.password} />
					</div>

					<Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
						{processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
						Accepter l'invitation
					</Button>
				</div>
			</form>
		</AuthLayout>
	);
}
