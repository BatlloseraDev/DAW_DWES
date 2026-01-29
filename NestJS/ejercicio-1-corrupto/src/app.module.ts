import { Module } from '@nestjs/common';

import { TrivialModule } from './trivial/trivial.module';
import { TrivialController } from './trivial/trivial.controller';
import { TrivialService } from './trivial/trivial.service';

@Module({
  imports: [],
  controllers: [TrivialController],
  providers: [TrivialService],
})
export class AppModule {}
